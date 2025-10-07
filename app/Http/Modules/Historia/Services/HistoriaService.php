<?php

namespace App\Http\Modules\Historia\Services;

use App\Http\Modules\Ordenamiento\Http\FomagHttp;
use App\Http\Modules\Ordenamiento\Models\Orden;
use App\Http\Modules\Ordenamiento\Models\SeguimientoEnvioOrden;
use Illuminate\Support\Carbon;
use App\Enums\TipoDocumentoEnum;
use App\Http\Services\ZipService;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use App\Formats\HistoriaClinicaIntegralBase;

use App\Http\Modules\Consultas\Models\Consulta;
use App\Http\Modules\Historia\Models\HistoriaClinica;
use App\Http\Modules\Consultas\Repositories\ConsultaRepository;
use App\Http\Modules\Historia\Neuropsicologia\Models\Neuropsicologia;
use App\Http\Modules\Historia\AntecedentesGinecologicos\CupMamografia;
use App\Http\Modules\Historia\AntecedentesGinecologicos\CupGinecologico;
use App\Http\Modules\AdmisionesUrgencias\Repositories\AdmisionesUrgenciaRepository;
use App\Http\Modules\Cie10Afiliado\Repositories\Cie10AfiliadoRepository;
use App\Http\Modules\Consultas\Models\ConsultaOrdenProcedimientos;
use App\Http\Modules\GestionOrdenPrestador\Repositories\GestionOrdenPrestadorRepository;
use App\Http\Modules\Historia\EscalaAbreviadaDesarrollos\Models\EscalaAbreviadaDesarrollo;
use App\Http\Modules\Historia\EscalaAbreviadaDesarrollos\Repositories\EscalaAbreviadaDesarrolloRepository;
use App\Http\Modules\Ordenamiento\Repositories\OrdenCodigoPropioRepository;
use App\Http\Modules\Ordenamiento\Repositories\OrdenProcedimientoRepository;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Log;

class HistoriaService
{
    public function __construct(
        private ConsultaRepository $consultaRepository,
        private EscalaAbreviadaDesarrolloRepository $escalaAbreviadaDesarrolloRepository,
        private HistoriaClinicaIntegralBase $serviceHistoriaClinicaIntegralBase,
        private AdmisionesUrgenciaRepository $admisionesUrgenciaRepository,
        private Cie10AfiliadoRepository $cie10AfiliadoRepository,
        private ConsultaOrdenProcedimientos $consultaOrdenProcedimientosModel,
        private OrdenProcedimientoRepository $ordenProcedimientoRepository,
        private OrdenCodigoPropioRepository $ordenCodigoPropioRepository,
        private GestionOrdenPrestadorRepository $gestionOrdenPrestadorRepository,
        protected FomagHttp $fomagHttp,
    ) {
    }

    function cupCitologia($consulta_id, $request)
    {
        return CupGinecologico::create([
            'consulta_id' => $consulta_id,
            'estado_ginecologia' => $request['citologia'],
            'cup_citologia_id' => $request['cup_citologia'],
            'descripcion_citologia' => $request['descripcion_citologia'],
            'resultados' => $request['resultados'],
            'fecha_realizacion' => $request['fecha_realizacion'],
            'afiliado_id' => $request['afiliado_id'],
            'created_by' => Auth::id()
        ]);
    }

    function cupMamografia($consulta_id, $request)
    {
        return CupMamografia::create([
            'consulta_id' => $consulta_id,
            'estado_mamografia' => $request['mamografiaPR'],
            'cup_mamografia_id' => $request['cup_mamografia'],
            'descripcion_mamografia' => $request['descripcion_mamografia'],
            'fecha_realizacion' => $request['fecha_realizacion'],
            'resultados' => $request['resultados'],
            'afiliado_id' => $request['afiliado_id'],
            'created_by' => Auth::id()
        ]);
    }

    public function actualizarImpresion($id, $data)
    {
        $actualizarImpresion = HistoriaClinica::findOrFail($id);
        return $actualizarImpresion->update($data);
    }

    public function guardarEscalaAbreviada($id, $data)
    {
        foreach ($data as $escala) {
            EscalaAbreviadaDesarrollo::updateOrCreate(
                [
                    'consulta_id' => $id,
                    'rango' => $escala['rango'],
                    'categoria' => $escala['categoria'],
                    'item' => $escala['item'],
                ],
                [
                    'valor_1' => $escala['valor_1'],
                    'valor_2' => $escala['valor_2'],
                    'valor_3' => $escala['valor_3'],
                    'valor_4' => $escala['valor_4'],
                ]
            );
        }
    }

    public function crearNeuropsicologia(array $data)
    {
        return Neuropsicologia::updateOrCreate(
            ['consulta_id' => $data['consulta_id']],
            $data
        );
    }

    public function obtenerDatosNeuropsicologia($afiliadoId)
    {
        return Neuropsicologia::select(
            'estado_animo_comportamiento',
            'actividades_basicas_instrumentales',
            'nivel_pre_morbido',
            'composicion_familiar',
            'evolucion_pruebas',
        )
            ->whereHas('consulta', function ($query) use ($afiliadoId) {
                $query->where('afiliado_id', $afiliadoId);
            })
            ->latest()
            ->first();
    }

    public function verificarFinalidad($consultaId)
    {
        return HistoriaClinica::where('consulta_id', $consultaId)
            ->whereNotNull('finalidad_id')
            ->whereNotNull('causa_consulta_externa_id')
            ->exists();
    }

    public function finalizarHistoriaUrgencias($consultaId)
    {
        DB::beginTransaction();
        try {
            $consulta = Consulta::find($consultaId);
            $this->admisionesUrgenciaRepository->actualizarAdmision($consulta->admision_urgencia_id);
            $consulta->estado_id = 9;
            $consulta->hora_fin_atendio_consulta = Carbon::now();
            $consulta->medico_ordena_id = auth()->id();
            $consulta->estado_triage = true;
            $consulta->save();
            DB::commit();
            return $consulta;
        } catch (\Throwable $th) {
            DB::rollBack();
            return 'Error';
        }
    }


    /**
     * finalizarHistoriaClinica
     *
     * @param  mixed $consulta_id
     * @param  mixed $data
     * @return void
     * @author Serna
     */
    public function finalizarHistoriaClinica(int $consulta_id, array $data)
    {
        DB::beginTransaction();
        try {
            $consulta = Consulta::findOrFail($consulta_id);
            $afiliado_id = $consulta->afiliado_id;

            foreach ($data as $ruta => $valores) {
                $modeloCompleto = "App\\Http\\Modules\\" . str_replace('/', '\\', $ruta);

                if (!class_exists($modeloCompleto)) {
                    Log::warning("Modelo no encontrado: {$modeloCompleto}");
                    continue;
                }

                if (str_contains($ruta, 'Afiliado')) {
                    $this->procesarModeloAfiliado($modeloCompleto, $valores, $afiliado_id);
                } else {
                    $this->procesarModeloConsulta($modeloCompleto, $valores, $consulta_id);
                }
            }

            $tieneDiagnosticos = $this->cie10AfiliadoRepository->verificarDiagnosticosAsociados($consulta_id);
            if (!$tieneDiagnosticos) {
                throw new \Exception('No se encontraron diagnósticos asociados a la consulta.');
            }

            $data =[
                'hora_fin_atendio_consulta' => Carbon::now(),
                'estado_id' => 9
            ];
            Consulta::where('id', $consulta_id)->update($data);

            // Actualizar ordenes del modulo prestadores
            $orden = $this->consultaOrdenProcedimientosModel->where('consulta_id', $consulta_id)->first();
            if ($orden) {
                $datosGestion = [
                    'fecha_asistencia' => Carbon::now(),
                    'observacion' => "Gestión creada automaticamente al cierre de la atención. Consecutivo de consulta {$consulta_id} ",
                    'estado_gestion_id' => 51
                ];

                if (!is_null($orden->orden_procedimiento_id)) {
                    $this->ordenProcedimientoRepository->actualizarEstadoGestionPrestador($orden->orden_procedimiento_id, 51);
                    $datosGestion['orden_procedimiento_id'] = $orden->orden_procedimiento_id;
                }
                if (!is_null($orden->orden_codigo_propio_id)) {
                    $this->ordenCodigoPropioRepository->actualizarEstadoGestionPrestador($orden->orden_codigo_propio_id, 51);
                    $datosGestion['orden_codigo_propio_id'] = $orden->orden_codigo_propio_id;
                }

                #crea la gestion
                $this->gestionOrdenPrestadorRepository->crear($datosGestion);
            }

            //envio historia a fomag por orden que viajo
            $orden = Orden::where('consulta_id', $consulta->id)->first();
            if (isset($orden)) {
                $this->descargarHistoriaEnvioFomag($consulta->id, $orden->id);
            }

            DB::commit();
            return 'Historia finalizada';
        } catch (\Throwable $th) {
            DB::rollBack();
            Log::error("Error al finalizar historia: " . $th->getMessage());
            throw $th;
        }
    }

    /**
     * Procesa y guarda información de un modelo relacionado con un afiliado.
     *
     * Añade el afiliado_id a los datos.
     * Valida si existen campos útiles (que no sean nulos o vacíos).
     * Si los datos son válidos, crea o actualiza el modelo usando el ID del afiliado.
     *
     * @param string $modelo Nombre completo del modelo.
     * @param array $valores Datos a guardar en el modelo.
     * @param int $afiliado_id ID del afiliado relacionado.
     * @return void
     */
    private function procesarModeloAfiliado($modelo, $valores, $afiliado_id)
    {
        $valores['afiliado_id'] = $afiliado_id;

        if (!$this->esModeloValido($valores, 'afiliado_id')) {
            Log::info("Se omitió el modelo {$modelo} porque todos los campos (excepto afiliado_id) están vacíos.");
            return;
        }

        $modelo::updateOrCreate(
            ['id' => $afiliado_id],
            $valores
        );
    }


    /**
     * Procesa y guarda información de un modelo relacionado con una consulta.
     * Añade el consulta_id a los datos.
     * Valida si existen campos útiles (que no sean nulos o vacíos).
     * Si los datos son válidos, crea o actualiza el modelo usando el consulta_id.
     * @param string $modelo Nombre completo del modelo.
     * @param array $valores Datos a guardar en el modelo.
     * @param int $consulta_id ID de la consulta relacionada.
     * @return void
     */
    private function procesarModeloConsulta($modelo, $valores, $consulta_id)
    {
        $valores['consulta_id'] = $consulta_id;

        if (!$this->esModeloValido($valores, 'consulta_id')) {
            Log::info("Se omitió el modelo {$modelo} porque todos los campos (excepto consulta_id) están vacíos.");
            return;
        }

        $modelo::updateOrCreate(
            ['consulta_id' => $consulta_id],
            $valores
        );
    }

    /**
     * Verifica si un modelo tiene al menos un campo con datos útiles (no nulos o vacíos)
     * @param array $valores El array de datos a evaluar.
     * @param string $claveExcluida La clave que debe excluirse de la evaluación.
     * @return bool true si existe al menos un campo útil; false si todos son nulos o vacíos.
     */
    private function esModeloValido(array $valores, string $claveExcluida): bool
    {
        return !collect($valores)
            ->except($claveExcluida)
            ->every(fn($valor) => is_null($valor) || $valor === '');
    }

    /**
     * se descarga la historia clinica que va viajar a por la orden que ya viajo desde sumimedical
     * la guarda en storage en una carpeta (historiaFomag) para despues se consultada por su contenido y proceder con su envio, 
     * una vez enviada se elimina del storage
     * @param int $consultaId
     * @param int $ordenId
     * @return bool
     * @author jose vas
     */
    public function descargarHistoriaEnvioFomag(int $consultaId, int $ordenId): bool
    {
        $envioFomag = SeguimientoEnvioOrden::where('orden_id', $ordenId)->where('code', 200)->first();

        if (!$envioFomag) {
            return false;
        }

        $request = new \stdClass();
        $request->consulta = $consultaId;

        $consulta = $this->consultaRepository->consultarCompleto($request, 'HistoriaClinica');

        $path = storage_path('app/historiaFomag/');

        if (!file_exists($path)) {
            mkdir($path, 0755, true);
        }

        $filename = "historia-orden-{$ordenId}.pdf";
        $fullPath = $path . $filename;

        $generarHistoria = new HistoriaClinicaIntegralBase('P', 'mm', 'A4');
        $generarHistoria->generar($consulta, null, null, $fullPath);


        $this->fomagHttp->enviarHistoriaFomag($ordenId, $fullPath);

        if (file_exists($fullPath)) {
            unlink($fullPath);
        }

        return true;
    }

}
