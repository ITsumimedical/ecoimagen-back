<?php

namespace App\Http\Modules\Contratos\Services;

use App\Http\Modules\AdjuntoNovedadContratos\Models\AdjuntoNovedadContrato;
use App\Http\Modules\Afiliados\Models\Afiliado;
use App\Http\Modules\Afiliados\Repositories\AfiliadoRepository;
use App\Http\Modules\Citas\Models\Cita;
use App\Http\Modules\Consultas\Models\Consulta;
use App\Http\Modules\Consultas\Models\ConsultaOrdenProcedimientos;
use App\Http\Modules\Contratos\Models\CobroServicio;
use App\Http\Modules\Contratos\Models\Contrato;
use App\Http\Modules\Contratos\Repositories\CobroServicioRepository;
use App\Http\Modules\Cups\Models\Cup;
use App\Http\Modules\Cups\Models\CupEntidad;
use App\Http\Modules\Cups\Repositories\CupEntidadRepository;
use App\Http\Modules\Cups\Repositories\CupRepository;
use App\Http\Modules\CupTarifas\Models\CupTarifa;
use App\Http\Modules\CupTarifas\Repositories\CupTarifaRepository;
use App\Http\Modules\Entidad\Models\Entidad;
use App\Http\Modules\NovedadContratos\Models\NovedadContrato;
use App\Http\Modules\NovedadContratos\NovedadContratoService;
use App\Http\Modules\Ordenamiento\Models\OrdenCodigoPropio;
use App\Http\Modules\Ordenamiento\Models\OrdenProcedimiento;
use App\Http\Modules\Ordenamiento\Repositories\OrdenCodigoPropioRepository;
use App\Http\Modules\Ordenamiento\Repositories\OrdenProcedimientoRepository;
use App\Http\Modules\Prestadores\Models\Prestador;
use App\Http\Modules\SalarioMinimo\Models\SalarioMinimo;
use App\Http\Modules\Tarifas\Models\Tarifa;
use App\Traits\ArchivosTrait;
use Carbon\Carbon;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;
use Rap2hpoutre\FastExcel\FastExcel;
use Illuminate\Http\UploadedFile;
use Error;
use Illuminate\Validation\ValidationException;
use Symfony\Component\HttpFoundation\BinaryFileResponse;

class ContratoService
{
    use ArchivosTrait;

    /**
     * @var NovedadContratoService
     */
    private NovedadContratoService $novedadContratoService;

    /**
     * Constructor del servicio de contratos.
     *
     * @param NovedadContratoService $novedadContratoService
     */
    public function __construct(
        NovedadContratoService $novedadContratoService,
        protected CobroServicioRepository $cobroServicioRepository,
        protected CupTarifaRepository $cupTarifaRepository,
        protected CupEntidadRepository $cupEntidadRepository,
        private readonly OrdenProcedimientoRepository $ordenProcedimientoRepository,
        private readonly OrdenCodigoPropioRepository $ordenCodigoPropioRepository,
        private readonly AfiliadoRepository $afiliadoRepository,

    ) {
        $this->novedadContratoService = $novedadContratoService;
    }

    /**
     * Carga CUPS desde un archivo Excel y los asocia al contrato especificado.
     *
     * @param UploadedFile $file
     * @param int $contratoId
     * @return array
     * @throws \Exception Si ocurre un error durante la carga.
     */
    public function cargar(UploadedFile $file, int $contratoId): array
    {
        DB::beginTransaction();

        try {
            $excel = (new FastExcel)->import($file->getRealPath());
            $resultado = 'Tarifas cargadas con éxito';
            $errores = [];

            foreach ($excel as $row) {
                // Validar datos necesarios
                if (!isset($row['codigo'], $row['valor'])) {
                    $errores[] = "Fila incompleta: " . json_encode($row);
                    continue;
                }

                $cups = Cup::where('codigo', $row['codigo'])->first();

                if (!$cups) {
                    $errores[] = "CUPS con código {$row['codigo']} no encontrado.";
                    continue;
                }

                $contrato = Contrato::findOrFail($contratoId);

                // Evitar duplicados
                if ($contrato->cups()->where('cups.id', $cups->id)->exists()) {
                    $errores[] = "El CUPS con código {$row['codigo']} ya está asociado al contrato.";
                    continue;
                }

                // Asociar CUPS al contrato con el valor especificado
                $contrato->cups()->attach($cups->id, ['valor' => $row['valor']]);
            }

            DB::commit();

            if (!empty($errores)) {
                $resultado = 'Tarifas cargadas con algunos errores.';
            }

            return [
                'resultado' => $resultado,
                'errores' => $errores,
            ];
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Error al cargar CUPS: ' . $e->getMessage(), ['exception' => $e]);
            throw new \Exception('Error al cargar las tarifas.', 500);
        }
    }

    /**
     * Guarda una novedad asociada a un contrato.
     *
     * @param \Illuminate\Http\Request $data
     * @param int $contratoId
     * @return mixed
     * @throws \Exception Si ocurre un error al guardar la novedad.
     */
    public function guardarNovedad($data, int $contratoId)
    {
        DB::beginTransaction();

        try {
            $novedad = NovedadContrato::create([
                'descripcion' => $data['novedad'],
                'contrato_id' => $contratoId,
                'user_id' => auth()->id(),
            ]);

            if (isset($data['files']) && is_array($data['files']) && count($data['files']) >= 1) {
                $this->guardarAdjuntos($data['files'], $novedad->id);
            }

            DB::commit();

            return $novedad;
        } catch (\Exception $e) {
            DB::rollBack();
            throw new \Exception($e->getMessage(), 500);
        }
    }

    /**
     * Guarda los archivos adjuntos de una novedad de contrato.
     *
     * @param \Illuminate\Http\Request $data
     * @param int $novedadId
     * @return AdjuntoNovedadContrato|null
     * @throws \Exception Si ocurre un error al guardar los adjuntos.
     */
    private function guardarAdjuntos($data, int $novedadId): ?AdjuntoNovedadContrato
    {
        try {
            $archivos = $data;
            $ruta = 'adjuntoContratos';

            foreach ($archivos as $archivo) {
                $nombre = $archivo->getClientOriginalName();
                $rutaSubida = $this->subirArchivoNombre($ruta, $archivo, $nombre, 'server37');

                AdjuntoNovedadContrato::create([
                    'nombre' => $nombre,
                    'ruta' => $rutaSubida,
                    'contrato_novedad_id' => $novedadId,
                ]);
            }

            return null;
        } catch (\Exception $e) {
            Log::error('Error al guardar adjuntos: ' . $e->getMessage(), ['exception' => $e]);
            throw new \Exception('Error al guardar los adjuntos.', 500);
        }
    }

    /**
     * Elimina un contrato y sus relaciones asociadas.
     *
     * @param int $contratoId
     * @return bool
     * @throws \Exception Si ocurre un error al eliminar el contrato.
     */
    public function eliminarContrato(int $contrato_id): bool
    {
        // Obtener todas las tarifas asociadas al contrato
        $tarifas = Tarifa::where('contrato_id', $contrato_id)->get();

        if ($tarifas->isNotEmpty()) {
            foreach ($tarifas as $tarifa) {
                // Eliminar registros de la tabla intermedia cup_tarifa
                CupTarifa::where('tarifa_id', $tarifa->id)->delete();

                // Eliminar registros de la tabla intermedia codigo_propio_tarifas utilizando DB
                DB::table('codigo_propio_tarifas')->where('tarifa_id', $tarifa->id)->delete();

                // Eliminar registros de la tabla intermedia paquete_tarifas utilizando DB
                DB::table('paquete_tarifas')->where('tarifa_id', $tarifa->id)->delete();

                // Eliminar registros de la tabla intermedia familia_tarifas utilizando DB
                DB::table('familia_tarifas')->where('tarifa_id', $tarifa->id)->delete();

                // Finalmente, eliminar la tarifa
                $tarifa->delete();
            }
        }

        // Eliminar el contrato
        Contrato::where('id', $contrato_id)->delete();

        return true;
    }

    /**
     * Crea un nuevo contrato.
     *
     * @param array $data
     * @return Contrato
     * @throws \Exception Si el prestador ya tiene un contrato con la entidad.
     */
    public function crear(array $data): Contrato
    {
        DB::beginTransaction();

        try {
            // Validar que la entidad no tenga un contrato ya con el prestador
            if ($this->tieneContrato($data['entidad_id'], $data['prestador_id'])) {
                $entidad = Entidad::find($data['entidad_id']);
                $prestador = Prestador::find($data['prestador_id']);

                $entidadNombre = $entidad ? $entidad->nombre : 'Entidad desconocida';
                $prestadorNombre = $prestador ? $prestador->nombre_prestador : 'Prestador desconocido';

                throw new \Exception("El prestador {$prestadorNombre} ya tiene un contrato con la entidad {$entidadNombre}.", 422);
            }

            $contrato = Contrato::create($data);

            DB::commit();

            return $contrato;
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Error al crear contrato: ' . $e->getMessage(), ['exception' => $e, 'data' => $data]);
            throw $e;
        }
    }

    /**
     * Actualiza un contrato y crea una novedad correspondiente.
     *
     * @param int $contratoId
     * @param array $data
     * @return Contrato
     * @throws \Exception Si ocurre un error durante la actualización.
     */
    public function actualizar(int $contratoId, array $data): Contrato
    {
        DB::beginTransaction();

        try {
            $contrato = Contrato::findOrFail($contratoId);

            $contratoData = Arr::except($data, ['novedad']);
            $contrato->update([
                'fecha_termina' => $contratoData['fecha_termina'],
                'ambito_id' => $contratoData['ambito_id'],
                'capitado' =>  $contratoData['capitado'],
                'pgp'  => $contratoData['pgp'],
                'evento'  => $contratoData['evento'],
                'descripcion' => $contratoData['descripcion'],
                'entidad_id' => $contratoData['entidad_id'],
                'fecha_inicio' => $contratoData['fecha_inicio'],
                'poliza'                 => $contratoData['poliza'],
                'renovacion'             => $contratoData['renovacion'],
                'modificacion'           => $contratoData['modificacion'],
                'tipo_reporte'            => $contratoData['tipo_reporte'],
                'linea_negocio'         => $contratoData['linea_negocio'],
                'regimen'                => $contratoData['regimen'],
                'naturaleza_juridica'    => $contratoData['naturaleza_juridica'],
                'componente'             => $contratoData['componente'],
                'tipo_servicio'          => $contratoData['tipo_servicio'],
                'tipo_relacion'          => $contratoData['tipo_relacion'],
                'codigo_contrato'        => $contratoData['codigo_contrato'],
                'obj_contrato'           => $contratoData['obj_contrato'],
                'poblacion_cubierta'    => $contratoData['poblacion_cubierta'],
                'modalidad_pago'         => $contratoData['modalidad_pago'],
                'otra_modalidad'         => $contratoData['otra_modalidad'],
                'tipo_modificacion'      => $contratoData['tipo_modificacion'],
                'valor_contrato'         => $contratoData['valor_contrato'],
                'valor_adicion'          => $contratoData['valor_adicion'],
                'valor_ejecutado'        => $contratoData['valor_ejecutado'],
                'tipo_proveedor'         => $contratoData['tipo_proveedor'],
                'estado' => 1,
            ]);

            if (isset($data['novedad'])) {
                $novedad = $this->guardarNovedad($data, $contrato->id);
            }

            DB::commit();

            return $contrato;
        } catch (\Exception $e) {
            DB::rollBack();
            throw new \Exception($e->getMessage(), 500);
        }
    }

    /**
     * Verifica si una entidad ya tiene un contrato con un prestador específico.
     *
     * @param int $entidadId
     * @param int $prestadorId
     * @return bool
     */
    public function tieneContrato(int $entidadId, int $prestadorId): bool
    {
        return Contrato::where('entidad_id', $entidadId)
            ->where('prestador_id', $prestadorId)
            ->exists();
    }

    /**
     * Carga un archivo Excel con varios contratos y genera un Excel de errores detallados si los hay.
     * Antes de guardar, transforma cada dato al tipo que requiere la base de datos.
     * @param $file
     */
    public function cargaMasiva($file)
    {
        // Leemos el Excel y aseguramos que el código de habilitación se trate como texto
        $excel = (new FastExcel)->import($file, function ($row) {
            $row['codigo_habilitacion_prestador'] = str_pad($row['codigo_habilitacion_prestador'], 10, '0', STR_PAD_LEFT);
            return $row;
        });

        $errores = [];
        $contratosConErrores = [];
        $contratos = [];
        $registroUnico = [];

        foreach ($excel as $linea => $data) {
            $errorMessages = [];

            // Clave única basada en codigo_habilitacion_prestador
            $claveUnica = $data['codigo_habilitacion_prestador'];

            // Verificamos si ya procesamos este par de codigo_habilitacion_prestador
            if (isset($registroUnico[$claveUnica])) {
                $mensaje = 'El prestador con código de habilitación ' . $data['codigo_habilitacion_prestador'] . ' está duplicado en el archivo. Solo se guardó el primer registro.';
                $errorMessages[] = $mensaje;
                $errores[] = 'Línea ' . ($linea + 1) . ': ' . $mensaje;

                $data['errors'] = implode('; ', $errorMessages);
                $contratosConErrores[] = $data;
                continue;
            } else {
                // Marcamos este par como procesado
                $registroUnico[$claveUnica] = true;
            }

            // Buscamos el prestador por el código de habilitación
            $prestador = Prestador::where('codigo_habilitacion', $data['codigo_habilitacion_prestador'])->first();

            if (!$prestador) {
                $mensaje = 'El prestador con código de habilitación ' . $data['codigo_habilitacion_prestador'] . ' no existe en la base de datos';
                $errorMessages[] = $mensaje;
                $errores[] = 'Línea ' . ($linea + 1) . ': ' . $mensaje;

                $data['errors'] = implode('; ', $errorMessages);
                $contratosConErrores[] = $data;
                continue;
            }

            // Validamos que la entidad no tenga un contrato ya con el prestador
            if ($this->tieneContrato(1, $prestador->id)) {
                $mensaje = 'El prestador ' . $data['codigo_habilitacion_prestador'] . ' ya tiene un contrato con la entidad Fomag';
                $errorMessages[] = $mensaje;
                $errores[] = 'Línea ' . ($linea + 1) . ': ' . $mensaje;

                $data['errors'] = implode('; ', $errorMessages);
                $contratosConErrores[] = $data;
                continue;
            }

            // Asignamos la data necesaria para la validación
            $dataParaValidar = $data;
            $dataParaValidar['entidad_id'] = 1;
            $dataParaValidar['prestador_id'] = $prestador->id;
            $dataParaValidar['codigo_habilitacion'] = $prestador->codigo_habilitacion;

            // Validamos el registro
            $validator = Validator::make($dataParaValidar, $this->reglasDeValidacionCargaMasiva());

            if ($validator->fails()) {
                $erroresValidacion = $validator->errors()->all();
                $errorMessages = array_merge($errorMessages, $erroresValidacion);
                foreach ($erroresValidacion as $errorMsg) {
                    $errores[] = 'Línea ' . ($linea + 1) . ': ' . $errorMsg;
                }

                $data['errors'] = implode('; ', $errorMessages);
                $contratosConErrores[] = $data;
                continue;
            }

            // Obtenemos los datos validados
            $validatedData = $validator->validated();

            // Transformamos los datos al tipo requerido por la base de datos

            // Campos bigint (integer)
            $validatedData['prestador_id'] = (int)$validatedData['prestador_id'];
            $validatedData['ambito_id'] = (int)$validatedData['ambito_id'];
            $validatedData['entidad_id'] = (int)$validatedData['entidad_id'];
            $validatedData['poblacion_cubierta'] = isset($validatedData['poblacion_cubierta']) ? (int)$validatedData['poblacion_cubierta'] : 0;

            // Campos bit (booleano, 0 o 1)
            $validatedData['capitado'] = isset($validatedData['capitado']) ? (bool)$validatedData['capitado'] : false;
            $validatedData['pgp'] = isset($validatedData['pgp']) ? (bool)$validatedData['pgp'] : false;
            $validatedData['evento'] = isset($validatedData['evento']) ? (bool)$validatedData['evento'] : false;
            $validatedData['poliza'] = isset($validatedData['poliza']) ? (bool)$validatedData['poliza'] : false;
            $validatedData['renovacion'] = isset($validatedData['renovacion']) ? (bool)$validatedData['renovacion'] : false;
            $validatedData['activo'] = true; // Asumiendo que los contratos nuevos están activos

            // Campos datetime y date
            $validatedData['fecha_inicio'] = isset($validatedData['fecha_inicio']) ? Carbon::parse($validatedData['fecha_inicio'])->format('Y-m-d H:i:s') : null;
            $validatedData['fecha_termina'] = isset($validatedData['fecha_termina']) ? Carbon::parse($validatedData['fecha_termina'])->format('Y-m-d H:i:s') : null;

            // Campos float (convertimos a float)
            if (!is_null($validatedData['valor_contrato'])) {
                $validatedData['valor_contrato'] = round((float)$validatedData['valor_contrato'], 2);
            }
            if (!is_null($validatedData['valor_adicion'])) {
                $validatedData['valor_adicion'] = round((float)$validatedData['valor_adicion'], 2);
            }
            if (!is_null($validatedData['valor_ejecutado'])) {
                $validatedData['valor_ejecutado'] = round((float)$validatedData['valor_ejecutado'], 2);
            }

            // Campos nvarchar(255) (strings, máximo 255 caracteres)
            $camposNVarchar255 = [
                'modificacion',
                'tipo_reporte',
                'linea_negocio',
                'regimen',
                'documento_proveedor_id',
                'documento_proveedor',
                'naturaleza_juridica',
                'codigo_habilitacion',
                'componente',
                'tipo_servicio',
                'tipo_relacion',
                'codigo_contrato',
                'obj_contrato',
                'modalidad_pago',
                'otra_modalidad',
                'tipo_modificacion',
                'estado',
                'union_temporal',
                'union_temporal_id',
                'tipo_proveedor',
                'tipo_red'
            ];

            foreach ($camposNVarchar255 as $campo) {
                if (isset($validatedData[$campo])) {
                    $validatedData[$campo] = substr((string)$validatedData[$campo], 0, 255);
                } else {
                    $validatedData[$campo] = null; // Aseguramos que el campo exista
                }
            }

            // Campos nvarchar(max) (strings, sin límite)
            $validatedData['descripcion'] = isset($validatedData['descripcion']) ? (string)$validatedData['descripcion'] : null;
            $validatedData['obj_contrato'] = isset($validatedData['obj_contrato']) ? (string)$validatedData['obj_contrato'] : null;

            // Aseguramos que los campos 'created_at' y 'updated_at' estén presentes
            $validatedData['created_at'] = now();
            $validatedData['updated_at'] = now();

            // Agregamos el contrato válido al arreglo
            $contratos[] = $validatedData;
        }

        // Insertamos los contratos válidos en la base de datos
        if (count($contratos) > 0) {
            Contrato::insert($contratos);
        }

        // Si hubo errores, generamos el Excel con los registros erróneos y sus detalles
        if (count($errores) > 0) {
            $excelEnBase64 = $this->generarExcelBase64($contratosConErrores);
            $response = [
                'errores' => $errores,
                'excel' => [
                    'archivo' => $excelEnBase64,
                    'nombre' => "errores.xlsx",
                    'extension' => "application/vnd.openxmlformats-officedocument.spreadsheetml.sheet"
                ]
            ];
            throw new Error(json_encode($response), 422);
        }

        // Retornamos los contratos insertados si no hubo errores
        return [
            'contratos' => $contratos,
            'message' => 'Carga masiva exitosa',
        ];
    }

    /**
     * Define las reglas de validación para la carga masiva de contratos.
     *
     * @return array
     */
    public static function reglasDeValidacionCargaMasiva(): array
    {
        return [
            'prestador_id' => 'required|integer',
            'ambito_id' => 'required|exists:ambitos,id|integer',
            'fecha_termina' => 'required|date',
            'fecha_inicio' => 'required|date',
            'entidad_id' => 'required|integer',
            'capitado' => 'boolean',
            'pgp' => 'boolean',
            'evento' => 'boolean',
            'poliza' => 'boolean',
            'renovacion' => 'boolean',
            'modificacion' => 'nullable',
            'descripcion' => 'required|string',
            // Campos adicionales
            'tipo_reporte' => 'nullable',
            'linea_negocio' => 'nullable',
            'regimen' => 'nullable',
            'documento_proveedor_id' => 'nullable',
            'documento_proveedor' => 'nullable',
            'naturaleza_juridica' => 'nullable',
            'codigo_habilitacion' => 'required',
            'componente' => 'nullable',
            'tipo_servicio' => 'nullable',
            'tipo_relacion' => 'nullable',
            'codigo_contrato' => 'nullable',
            'obj_contrato' => 'nullable|string',
            'poblacion_cubierta' => 'nullable|integer',
            'modalidad_pago' => 'nullable',
            'otra_modalidad' => 'nullable',
            'tipo_modificacion' => 'nullable',
            'valor_contrato' => 'nullable|numeric',
            'valor_adicion' => 'nullable|numeric',
            'valor_ejecutado' => 'nullable|numeric',
            'estado' => 'nullable',
            'union_temporal' => 'nullable',
            'union_temporal_id' => 'nullable',
            'tipo_proveedor' => 'nullable',
            'tipo_red' => 'nullable',
        ];
    }

    /**
     * Genera un archivo Excel codificado en Base64 a partir de los datos proporcionados.
     *
     * @param array $datos
     * @return string
     */
    private function generarExcelBase64(array $datos): string
    {
        $excel = (new FastExcel($datos))->export('php://temp');

        $tempFile = tempnam(sys_get_temp_dir(), 'errores');
        (new FastExcel($datos))->export($tempFile);

        $contenido = file_get_contents($tempFile);
        unlink($tempFile);

        return base64_encode($contenido);
    }


    /**
     * Consulta sp de contratos.
     * @return array
     */
    public function descargarContratos()
    {

        $appointments = collect(DB::select('SELECT * FROM fn_listado_contratos()'));
        return $array = json_decode($appointments, true);
    }

    public function calcularValorServicio(int $idServicio, int $tipo)
    {
        try {
            $ordenServicio = $this->obtenerOrdenServicio($tipo, $idServicio);
            if (!$ordenServicio || !optional($ordenServicio->orden)->consulta) return false;
            $consulta = $ordenServicio->orden->consulta;
            $afiliado = $this->afiliadoRepository->getAfiliadoById($consulta->afiliado_id);
            if (!$afiliado) return false;
            $cobro = $this->createCobroServicio($tipo, $idServicio, $afiliado, $ordenServicio, $consulta);
            return true;
        } catch (\Exception $e) {
            throw new \Exception('Error al calcular el valor del servicio.' . $e->getMessage(), 500);
        }
    }

    private function createCobroServicio(int $tipo, int $idServicio, $afiliado, $ordenServicio, $consulta)
    {
        $cobroServicio = new CobroServicio([
            'orden_procedimiento_id' => $tipo == 2 ? $idServicio : null,
            'orden_codigo_propio_id' => $tipo == 4 ? $idServicio : null,
        ]);
        [$valor, $tipoCobro] = $this->determinarValorCobro($afiliado, $ordenServicio, $ordenServicio, $consulta);
        $cobroServicio->valor = $valor;
        $cobroServicio->tipo = $tipoCobro;

        return CobroServicio::create([
            'tipo' => $cobroServicio->tipo,
            'valor' => $cobroServicio->valor,
            'estado_id' => 1,
            'orden_procedimiento_id' => $cobroServicio->orden_procedimiento_id,
            'orden_codigo_propio_id' => $cobroServicio->orden_codigo_propio_id,
            'consulta_id' => $consulta->id,
            'afiliado_id' => $afiliado->id,
        ]);
    }

    private function obtenerOrdenServicio(int $tipo, int $idServicio)
    {
        switch ($tipo) {
            case 2:
                return $this->ordenProcedimientoRepository->getOrdenProcedimientoById($idServicio);
            case 4:
                return $this->ordenCodigoPropioRepository->getOrdenCodigoPropioById($idServicio);
            default:
                return null;
        }
    }

    public function determinarValorCobro($afiliado, $ordenServicio, $consulta)
    {
        if (!$this->afiliadoAplicaCobro($afiliado) || !$this->consultaAplicaCobro($consulta)) {
            return [0, 'Exento'];
        }
        $valores = $this->valoresPlan($afiliado->categoria, $ordenServicio->fecha_vigencia);
        $cupEntidad = $this->cupEntidadRepository->getCupEntidadByAfiliadoAndCup($afiliado->entidad_id, $ordenServicio->cup);

        if (!$cupEntidad) {
            return [0, 'Exento'];
        }

        $tipoAfiliado = optional($afiliado->TipoAfiliado)->clasificacion_afiliado;
        $esSubsidiadoNoA = $afiliado->tipo_afiliacion_id == 2 && $afiliado->categoria !== 'A';
        $esBeneficiario = $tipoAfiliado === 'BENEFICIARIO';
        $esContributivoBeneficiario = $afiliado->tipo_afiliado_id == 1 && $afiliado->tipo_afiliacion_id === 1;

        $aplicaCopago = $cupEntidad->copago && ($esBeneficiario || $esSubsidiadoNoA || $esContributivoBeneficiario);
        $aplicaCuota = $cupEntidad->moderadora;

        if ($aplicaCopago) {
            $valorServicio = $this->cupTarifaRepository->tarifaCupEntidadPrestador(
                $ordenServicio->cup,
                $afiliado->entidad_id,
                $ordenServicio->rep
            );

            if (!$valorServicio) {
                return [$valores['cuota_moderadora'], 'cuota'];
            }
            if ($esSubsidiadoNoA) {
                $porcentaje = $valores['copago_subsidiado'];
                $topeEvento = $valores['copago_subsidiado_tope_evento'];
                $topeAnual = $valores['copago_subsidiado_tope_anual'];
                $acumuladoAnual = $this->cobroServicioRepository->acumuladoAnualSubsidiado(
                    $afiliado->id,
                    date('Y', strtotime($ordenServicio->fecha_vigencia))
                );
            } else {
                $porcentaje = $valores['porcentaje_copago'];
                $topeEvento = $valores['tope_evento'];
                $topeAnual = $valores['tope_anual'];
                $acumuladoAnual = $this->cobroServicioRepository->acumuladoAnual(
                    $afiliado->id,
                    date('Y', strtotime($ordenServicio->fecha_vigencia))
                );
            }

            $copago = ceil((intval($valorServicio->valor) * floatval($porcentaje)) / 100);
            $copago = min($copago, $topeEvento);

            $diferenciaTopeAnual = $topeAnual - $acumuladoAnual;
            if ($diferenciaTopeAnual <= 50) {
                return [0, 'copago'];
            }

            if ($copago > $diferenciaTopeAnual) {
                $copago = $diferenciaTopeAnual;
            }

            return [$copago, 'copago'];
        }

        if ($aplicaCuota) {
            return [$valores['cuota_moderadora'], 'cuota'];
        }

        return [0, 'Exento'];
    }


    public function valoresPlan($plan, $fechaServicio)
    {
        $valores = [];
        $anioServicio = date('Y', strtotime($fechaServicio));
        $salarioMinimo = SalarioMinimo::where('anio', $anioServicio)->first();
        switch ($plan) {
            case 'A':
                $valores['porcentaje_copago'] = $salarioMinimo->copago_a;
                $valores['cuota_moderadora'] = $salarioMinimo->cuota_moderadora_a;
                $valores['tope_evento'] = $salarioMinimo->copago_tope_evento_a;
                $valores['tope_anual'] = $salarioMinimo->copago_tope_anual_a;
                break;
            case 'B':
                $valores['porcentaje_copago'] = $salarioMinimo->copago_b;
                $valores['cuota_moderadora'] = $salarioMinimo->cuota_moderadora_b;
                $valores['tope_evento'] = $salarioMinimo->copago_tope_evento_b;
                $valores['tope_anual'] = $salarioMinimo->copago_tope_anual_b;
                $valores['copago_subsidiado'] = $salarioMinimo->copago_subsidiado;
                $valores['copago_subsidiado_tope_evento'] = $salarioMinimo->copago_subsidiado_tope_evento;
                $valores['copago_subsidiado_tope_anual'] = $salarioMinimo->copago_subsidiado_tope_anual;
                break;
            case 'C':
                $valores['porcentaje_copago'] = $salarioMinimo->copago_c;
                $valores['cuota_moderadora'] = $salarioMinimo->cuota_moderadora_c;
                $valores['tope_evento'] = $salarioMinimo->copago_tope_evento_c;
                $valores['tope_anual'] = $salarioMinimo->copago_tope_anual_c;
                $valores['copago_subsidiado'] = $salarioMinimo->copago_subsidiado;
                $valores['copago_subsidiado_tope_evento'] = $salarioMinimo->copago_subsidiado_tope_evento;
                $valores['copago_subsidiado_tope_anual'] = $salarioMinimo->copago_subsidiado_tope_anual;
                break;
        }
        return $valores;
    }

    public function afiliadoAplicaCobro($afiliado)
    {
        $fechaNacimiento = Carbon::parse($afiliado->fecha_nacimiento);
        $now = Carbon::now();
        if ($fechaNacimiento->diffInYears($now) === 0) {
            return false;
        }
        $etnias = ['Afrocolombiano', 'Afrodescendiente', 'Indígena', 'Mulato', 'Palenquero', 'Raizal', 'Room'];
        if (array_search($afiliado->etnia, $etnias) !== false) {
            return false;
        }
        $filtroMarcacion = array_filter($afiliado['clasificacion']->toArray(), function ($item) {
            return ($item['id'] === 10 || $item['id'] === 24) && $item['estado'] === true;
        });

        if ($afiliado->exento_pago === 'Si') {
            return false;
        }

        if (!empty($filtroMarcacion)) {
            return false;
        }

        return true;
    }

    public function consultaAplicaCobro($consulta)
    {

        if (!empty($consulta['cie10Afiliado'])) {
            $filtrado = array_filter($consulta['cie10Afiliado']->toArray(), function ($item) {
                return $item['esprimario'] = true;
            });
            if (!empty($filtrado)) {
                if ($filtrado[0]['cie10']['huerfana'] === true) {
                    return false;
                }
            }
        }
        if ($consulta['HistoriaClinica'] && $consulta['HistoriaClinica']['finalidadConsulta']) {
            if ($consulta['HistoriaClinica']['finalidadConsulta']['pyp'] === true) {
                return false;
            }
        }
        return true;
    }

    public function acumuladoAnualInformativo($id)
    {
        $afiliado = Afiliado::find($id);
        if ($afiliado->tipo_afiliacion_id == 2) {
            $datos['acumulado'] = $this->cobroServicioRepository->acumuladoAnualSubsidiado($id, date('Y'));
        } else {
            $datos['acumulado'] = $this->cobroServicioRepository->acumuladoAnual($id, date('Y'));
        }
        $datos['valores'] = $this->valoresPlan($afiliado->categoria, date('Y-m-d'));
        return $datos;
    }

    public function cobroAgendamiento($idConsulta)
{
    try {
        $consulta = Consulta::with('afiliado')->find($idConsulta);
        $cupExento = Cita::where('id', $consulta->cita_id)->where('exento', true)->exists();
        $afiliadoSubsidiado = $consulta->afiliado->tipo_afiliacion_id == 2;

        if ($cupExento || $afiliadoSubsidiado) {
            $this->cobroServicioRepository->guardar(new CobroServicio([
                'valor' => 0,
                'consulta_id' => $idConsulta,
                'afiliado_id' => $consulta->afiliado->id,
                'tipo' => 'Exento',
                'usuario_cobra' => auth()->id(),
            ]));

            return true;
        }

        // Si aplica cobro
        if ($this->afiliadoAplicaCobro($consulta->afiliado) && $this->consultaAplicaCobro($consulta)) {
            $valores = $this->valoresPlan($consulta->afiliado->categoria, $consulta->fecha_hora_inicio);

            $this->cobroServicioRepository->guardar(new CobroServicio([
                'valor' => $valores['cuota_moderadora'],
                'consulta_id' => $idConsulta,
                'afiliado_id' => $consulta->afiliado->id,
                'tipo' => 'cuota',
                'usuario_cobra' => auth()->id(),
            ]));
        }

        return true;
    } catch (\Exception $e) {
        return false;
    }
}

}
