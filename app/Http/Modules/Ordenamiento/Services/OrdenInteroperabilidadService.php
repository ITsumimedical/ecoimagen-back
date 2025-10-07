<?php

namespace App\Http\Modules\Ordenamiento\Services;

use App\Enums\Homologos\Fomag\EspecialidadEnum;
use App\Enums\Homologos\Fomag\FinalidadTranscripcionEnum;
use App\Exceptions\NoDetallesFueraDeCapitaException;
use App\Http\Modules\Afiliados\Models\Afiliado;
use App\Http\Modules\Afiliados\Repositories\AfiliadoRepository;
use App\Http\Modules\Codesumis\codesumis\Repositories\CodesumiRepository;
use App\Http\Modules\Consultas\Repositories\ConsultaRepository;
use App\Http\Modules\Cups\Repositories\CupRepository;
use App\Http\Modules\Cups\Services\CupService;
use App\Http\Modules\Interoperabilidad\Repositories\RegistroRecepcionOrdenesInteroperabilidadRepository;
use App\Http\Modules\Ordenamiento\Http\FomagHttp;
use App\Http\Modules\Ordenamiento\Models\Orden;
use App\Http\Modules\Ordenamiento\Repositories\OrdenArticuloRepository;
use App\Http\Modules\Ordenamiento\Repositories\OrdenProcedimientoRepository;
use App\Http\Modules\Ordenamiento\Repositories\OrdenRepository;
use App\Http\Modules\Reps\Repositories\RepsRepository;
use App\Http\Modules\Transcripciones\Transcripcion\Repositories\TranscripcionRepository;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Error;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class OrdenInteroperabilidadService
{
    private $sedesSumimedical = [16024, 1876, 14024, 13742, 77592, 13740, 13743, 13741, 77524, 13739, 1609, 2959, 14124, 77590, 497, 1667, 1392, 70539, 1193, 14489, 51350, 3497, 51547];

    public function __construct(
        private FomagHttp $fomagHttp,
        private CupService $cupService,
        private readonly AfiliadoRepository $afiliadoRepository,
        private readonly ConsultaRepository $consultaRepository,
        private readonly TranscripcionRepository $transcripcionRepository,
        private readonly OrdenRepository $ordenRepository,
        private readonly OrdenProcedimientoRepository $ordenProcedimientoRepository,
        private readonly CupRepository $cupRepository,
        private readonly RepsRepository $repsRepository,
        private readonly CodesumiRepository $codesumiRepository,
        private readonly OrdenArticuloRepository $ordenArticuloRepository,
        private readonly RegistroRecepcionOrdenesInteroperabilidadRepository $registroRecepcionOrdenesInteroperabilidadRepository
    ) {}
    /**
     * prepara un json para enviar a fomag
     * @param Orden|int $orden
     * @return array
     * @author David Peláez
     */
    public function generarJson(Orden|int $orden)
    {
        # evaluamos si se envio la orden o su id
        if (!$orden instanceof Orden) {
            $orden = Orden::where('id', $orden)->firstOrFail();
        }

        # recuperamos la consulta
        $consulta = $orden->consulta;
        # recuperamos el afiliado
        $afiliado = $consulta->afiliado;
        # validamos que el afiliado pertezca a fomag
        if($afiliado->entidad_id === 3) {
            throw new Error("El afiliado pertenece a ferrocarriles", 422);
        }

        $capitadosOPGP = [];
        $noCapitadosNiPGP = [];
        # agrupamos los cups en los que estan en el manual tarifario 4 o 5 y los que no (estos ultimos son los que se van a enviar)
        foreach ($orden->detalles as $detalle) {
            $enManual = $this->cupService->verificarManual($detalle->cup_id, [4, 5], $this->sedesSumimedical);
            $data = [
                "interoperabilidad_id" => strval($detalle->id),
                "cup_codigo" => $detalle->cup->codigo,
                "rep_codigo_habilitacion" => $detalle->rep_id ? $detalle->rep->codigo_habilitacion : null,
                "estado" => $detalle->estado_id,
                "cantidad" => $detalle->cantidad,
                "fecha_vigencia" => $detalle->fecha_vigencia,
                "observacion" => $detalle->observacion,
                "autorizacion" => $detalle->autorizacion
            ];
            if ($enManual) {
                $capitadosOPGP[] = $data;
            } else {
                $noCapitadosNiPGP[] = $data;
            }
        }
        # si no hay detalles fuera de capitados o PGP, lanzamos una excepcion
        if (count($noCapitadosNiPGP) < 1) {
            throw new NoDetallesFueraDeCapitaException($capitadosOPGP);
        }

        #recuperamos el operador
        $operador = $orden->user->operador;
        # recuperamos el cup de la consulta
        $cupConsulta = $consulta->cup;
        # recuperamos el diagnostico primario
        $cie10Principal = $consulta->cie10Afiliado()->first();
        # recuperamos los adjntos
        $adjuntos = $consulta->adjuntos->map(function ($adjunto) {
            $archivo = Storage::disk('server37')->get($adjunto->ruta);
            if ($archivo) {
                return [
                    "nombre" => $adjunto->nombre,
                    "extension" => explode('.', $adjunto->nombre)[1],
                    "archivo" => base64_encode($archivo)
                ];
            }
        });

        $json = [
            "transcripcion" => [
                "numero_orden" => (string) $orden->id,
                "ambito" => 1,
                "medico_ordeno" => $operador->nombre . ' ' . $operador->apellido,
                "finalidad" => FinalidadTranscripcionEnum::homologo($consulta->finalidad),
                "observaciones" => "Transcripcion por interoperabilidad",
                "prestador_codigo" => "0536009022",
                "cie10_codigo" => $cie10Principal->cie10->codigo_cie10 ?? throw new Error("Problemas con el cie10", 404),
                "especialidad" => EspecialidadEnum::homologo($operador->especialidad),
                "documento_medico_ordena" => $operador->documento,
                "registro_medico_ordena" => $operador->registro_medico ?? $operador->documento,
                "firma_medico_base64" => "Sin firma",
            ],
            "consulta" => [
                "finalidad" => FinalidadTranscripcionEnum::homologo($consulta->finalidad),
                "fecha_hora_inicio" => $consulta->fecha_hora_inicio,
                "fecha_hora_final" => $consulta->fecha_hora_final,
                "afiliado_tipo_documento" => $afiliado->tipo_documento,
                "afiliado_numero_documento" => $afiliado->numero_documento,
                "cup_codigo" => $cupConsulta->codigo ?? null,
                "especialidad" => $consulta->especialidad_id,
                "adjuntos" => $adjuntos
            ],
            "orden" => [
                "tipo_orden" => $orden->tipo_orden_id,
                "estado" => 1
            ],
            "detalles" => $noCapitadosNiPGP
        ];

        return [
            "json" => $json,
            "capitadosOPGP" => $capitadosOPGP,
            "noCapitadosNiPGP" => $noCapitadosNiPGP
        ];
    }

    /**
     * envia la peticion
     * @param int $orden_id
     * @return array
     * @author David Peláez
     */
    public function enviar(Orden|int $orden)
    {
        # evaluamos si se envio la orden o su id
        if (!$orden instanceof Orden) {
            $orden = Orden::where('id', $orden)->firstOrFail();
        }
        # generamos el json y separamos los detalles
        $jsonYDetalles = $this->generarJson($orden);
        # enviamos la peticion
        $response = $this->fomagHttp->enviarOrden($jsonYDetalles['json']);
        if ($response->failed()) {
            if (is_array($response->json())) {
                throw new Error("Error al enviar la orden a Fomag: " . json_encode($response->json()), $response->status());
            }
            throw new Error("Error al enviar la orden a Fomag: " . json_encode($response->json()), $response->status());
        }
        return [
            // 'response' => $response->json(),
            'capitadosOPGP' => $jsonYDetalles['capitadosOPGP'],
            'noCapitadosNiPGP' => $jsonYDetalles['noCapitadosNiPGP']
        ];
    }

    /**
     * Crea una OrdenProcedimiento proveniente de FOMAG
     * @param array $data
     * @throws NotFoundHttpException
     * @return array
     * @author Thomas
     */
    public function crearOrdenProcedimiento(array $data): array
    {
        try {
            // Validar existencia del afiliado
            $afiliado = $this->afiliadoRepository->buscarAfiliadoTipoNumeroDocumento(
                $data['afiliado']['tipo_documento'],
                $data['afiliado']['numero_documento']
            );

            if (!$afiliado) {
                throw new NotFoundHttpException('No se encontró un afiliado con ese número y tipo de documento.');
            }

            // Validar existencia del Rep
            $rep = $this->repsRepository->buscarRepPorCodigoHabilitacionSede($data['rep_codigo_habilitacion']);
            if (!$rep) {
                throw new NotFoundHttpException('No se encontró un Rep con ese código.');
            }

            // Validar existencia del CUP
            $cup = $this->cupRepository->buscarCupPorCodigo($data['cup_codigo']);
            if (!$cup) {
                throw new NotFoundHttpException('No se encontró un CUP con ese código.');
            }

            $resultado = DB::transaction(function () use ($data, $afiliado, $cup, $rep): array {
                $consulta = $this->consultaRepository->crear([
                    'afiliado_id' => $afiliado->id,
                    'estado_id' => 9,
                    'cita_no_programada' => false,
                    'finalidad' => $data['finalidad'],
                    'tipo_consulta_id' => 1,
                ]);

                $transcripcion = $this->transcripcionRepository->crear([
                    'afiliado_id' => $afiliado->id,
                    'ambito' => $data['ambito'],
                    'finalidad' => $data['finalidad'],
                    'tipo_transcripcion' => 'Externa',
                    'observaciones' => $data['observacion'],
                    'consulta_id' => $consulta->id,
                    'nombre_medico_ordeno' => $data['medico_nombre'],
                    'documento_medico_ordeno' => $data['medico_documento'],
                ]);

                $ordenExistente = $this->ordenRepository->buscarOrdenInteroperabilidadId($data['orden_id']);

                $orden = $ordenExistente ?: $this->ordenRepository->crear([
                    'tipo_orden_id' => 2,
                    'consulta_id' => $consulta->id,
                    'estado_id' => 1,
                    'rep_id' => $rep->id,
                    'user_id' => config('services.fomag.user_fomag_interoperabilidad_id'),
                    'orden_id_interoperabilidad' => $data['orden_id'],
                ]);

                $procedimientoYaRegistrado = $this->ordenProcedimientoRepository->buscarProcedimientoInteroperabilidad($data['procedimiento_id']);

                $procedimiento = $procedimientoYaRegistrado ?: $this->ordenProcedimientoRepository->crear([
                    'orden_id' => $orden->id,
                    'cup_id' => $cup->id,
                    'estado_id' => 1,
                    'cantidad' => $data['cantidad'],
                    'fecha_vigencia' => $data['fecha_vigencia'],
                    'rep_id' => $rep->id,
                    'pdf_fomag' => $data['pdf'] ?? null,
                    'orden_procedimiento_id_interoperabilidad' => $data['procedimiento_id'],
                ]);

                return [
                    'orden_id' => $orden->id,
                    'orden_procedimiento_id' => $procedimiento->id,
                    'transcripcion_id' => $transcripcion->id,
                    'consulta_id' => $consulta->id,
                ];
            });

            // Registro de auditoría exitosa
            $this->registroRecepcionOrdenesInteroperabilidadRepository->crear([
                'orden_interoperabilidad_id' => $data['orden_id'],
                'orden_procedimiento_interoperabilidad_id' => $data['procedimiento_id'],
                'estado' => true,
                'payload' => $data,
            ]);

            return $resultado;
        } catch (\Throwable $e) {
            // Registro de auditoría por fallo
            $this->registroRecepcionOrdenesInteroperabilidadRepository->crear([
                'orden_interoperabilidad_id' => $data['orden_id'] ?? null,
                'orden_procedimiento_interoperabilidad_id' => $data['procedimiento_id'] ?? null,
                'estado' => false,
                'mensaje_error' => $e->getMessage(),
                'payload' => $data,
            ]);

            throw $e;
        }
    }


    /**
     * Crea una OrdenArticulo proveniente de FOMAG
     * @param array $data
     * @throws NotFoundHttpException
     * @return array
     * @author Thomas
     */
    public function crearOrdenMedicamento(array $data): array
    {
        try {
            // Validar existencia del afiliado
            $afiliado = $this->afiliadoRepository->buscarAfiliadoTipoNumeroDocumento(
                $data['afiliado']['tipo_documento'],
                $data['afiliado']['numero_documento']
            );

            if (!$afiliado) {
                throw new NotFoundHttpException('No se encontró un afiliado con ese número y tipo de documento.');
            }

            // Validar existencia del Rep
            $rep = $this->repsRepository->buscarRepPorCodigoHabilitacionSede($data['rep_codigo_habilitacion']);
            if (!$rep) {
                throw new NotFoundHttpException('No se encontró un Rep con ese código.');
            }

            // Validar existencia del Medicamento
            $codesumi = $this->codesumiRepository->buscarCodesumiPorCodigo($data['medicamento_codigo']);
            if (!$codesumi) {
                throw new NotFoundHttpException('No se encontró un Medicamento con ese código.');
            }

            DB::beginTransaction();

            $consulta = $this->consultaRepository->crear([
                'afiliado_id' => $afiliado->id,
                'estado_id' => 9,
                'cita_no_programada' => false,
                'finalidad' => $data['finalidad'],
                'tipo_consulta_id' => 1,
            ]);

            $transcripcion = $this->transcripcionRepository->crear([
                'afiliado_id' => $afiliado->id,
                'ambito' => $data['ambito'],
                'finalidad' => $data['finalidad'],
                'tipo_transcripcion' => 'Externa',
                'observaciones' => $data['observacion'],
                'consulta_id' => $consulta->id,
                'nombre_medico_ordeno' => $data['medico_nombre'],
                'documento_medico_ordeno' => $data['medico_documento'],
            ]);

            $ordenExistente = $this->ordenRepository->buscarOrdenInteroperabilidadId($data['orden_id']);

            $orden = $ordenExistente ?: $this->ordenRepository->crear([
                'tipo_orden_id' => 1,
                'consulta_id' => $consulta->id,
                'estado_id' => 1,
                'rep_id' => $rep->id,
                'user_id' => config('services.fomag.user_fomag_interoperabilidad_id'),
                'orden_id_interoperabilidad' => $data['orden_id'],
            ]);

            $articuloYaRegistrado = $this->ordenArticuloRepository->buscarArticuloInteroperabilidad($data['orden_medicamento_id']);

            $articulo = $articuloYaRegistrado ?: $this->ordenArticuloRepository->crear([
                'orden_id' => $orden->id,
                'codesumi_id' => $codesumi->id,
                'estado_id' => 1,
                'dosis' => $data['dosis'],
                'frecuencia' => $data['frecuencia'],
                'unidad_tiempo' => $data['unidad_tiempo'],
                'duracion' => $data['duracion'],
                'cantidad_mensual' => $data['cantidad_mensual'],
                'cantidad_mensual_disponible' => $data['cantidad_mensual_disponible'],
                'cantidad_medico' => $data['cantidad_medico'],
                'observacion' => $data['observacion'],
                'fecha_vigencia' => $data['fecha_vigencia'],
                'pdf_fomag' => $data['pdf'] ?? null,
                'meses' => $data['meses'],
                'domicilio' => false,
                'orden_articulo_id_interoperabilidad' => $data['orden_medicamento_id'],
            ]);

            // Registro de auditoría exitosa
            $this->registroRecepcionOrdenesInteroperabilidadRepository->crear([
                'orden_interoperabilidad_id' => $data['orden_id'],
                'orden_articulo_interoperabilidad_id' => $data['orden_medicamento_id'],
                'estado' => true,
                'payload' => $data,
            ]);

            DB::commit();

            return [
                'consulta' => $consulta,
                'transcripcion' => $transcripcion,
                'orden' => $orden,
                'articulo' => $articulo,
            ];
        } catch (\Throwable $e) {
            // Registro de auditoría por fallo
            DB::rollBack();
            $this->registroRecepcionOrdenesInteroperabilidadRepository->crear([
                'orden_interoperabilidad_id' => $data['orden_id'] ?? null,
                'orden_articulo_interoperabilidad_id' => $data['orden_medicamento_id'] ?? null,
                'estado' => false,
                'mensaje_error' => $e->getMessage(),
                'payload' => $data,
            ]);

            throw $e;
        }
    }
}
