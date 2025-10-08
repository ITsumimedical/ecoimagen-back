<?php

namespace App\Http\Modules\Ordenamiento\Services;

use App\Enums\EstadoOrdenMedicamentos;
use App\Http\Modules\Afiliados\Models\Afiliado;
use App\Http\Modules\Auditorias\Models\Auditoria;
use App\Http\Modules\Bodegas\Repositories\BodegaRepository;
use App\Http\Modules\BodegasReps\Model\BodegasReps;
use App\Http\Modules\BodegasReps\Repositories\BodegaRepRepository;
use App\Http\Modules\CambiosOrdenes\Models\CambiosOrdene;
use App\Http\Modules\CambiosOrdenes\Repositories\CambiosOrdenesRepository;
use App\Http\Modules\Cie10\Repositories\Cie10Repository;
use App\Http\Modules\CobroFacturas\Models\CobroFacturas;
use App\Http\Modules\Codesumis\codesumis\Repositories\CodesumiRepository;
use App\Http\Modules\CodigoPropios\Models\CodigoPropio;
use App\Http\Modules\CodigoPropios\Repositories\CodigoPropioRepository;
use App\Http\Modules\Consultas\Models\Consulta;
use App\Http\Modules\Consultas\Repositories\ConsultaRepository;
use App\Http\Modules\Contratos\Models\CobroServicio;
use App\Http\Modules\Contratos\Repositories\CobroServicioRepository;
use App\Http\Modules\Contratos\Services\ContratoService;
use App\Http\Modules\Cups\Models\Cup;
use App\Http\Modules\Cups\Models\CupEntidad;
use App\Http\Modules\Cups\Repositories\CupRepository;
use App\Http\Modules\Direccionamientos\Services\DireccionamientoService;
use App\Http\Modules\GestionOrdenPrestador\Repositories\GestionOrdenPrestadorRepository;
use App\Http\Modules\EntidadesCodesumiParametrizacion\Model\CodesumiEntidad;
use App\Http\Modules\Historia\AntecedentesFarmacologicos\Models\AntecedentesFarmacologico;
use App\Http\Modules\Ordenamiento\Repositories\OrdenCodigoPropioRepository;
use App\Http\Modules\Ordenamiento\Repositories\OrdenProcedimientoRepository;
use App\Http\Modules\Ordenamiento\Services\OrdenInteroperabilidadService;
use App\Http\Modules\Medicamentos\Models\Codesumi;
use App\Http\Modules\Medicamentos\Repositories\OrdenamientoRepository;
use App\Http\Modules\Movimientos\Models\Movimiento;
use App\Http\Modules\Ordenamiento\Http\FomagHttp;
use App\Http\Modules\Ordenamiento\Models\DientesOrdenProcedimiento;
use App\Http\Modules\Ordenamiento\Models\Orden;
use App\Http\Modules\Ordenamiento\Models\OrdenArticulo;
use App\Http\Modules\Ordenamiento\Models\OrdenProcedimiento;
use App\Http\Modules\Ordenamiento\Models\OrdenCodigoPropio;
use App\Http\Modules\Ordenamiento\Models\TipoOrden;
use App\Http\Modules\Ordenamiento\Repositories\OrdenArticuloIntrahospitalarioRepository;
use App\Http\Modules\Ordenamiento\Repositories\OrdenRepository;
use App\Http\Modules\ProgramasFarmacia\Repositories\ProgramasFarmaciaRepository;
use App\Http\Modules\Transcripciones\Transcripcion\Models\Transcripcione;
use App\Http\Services\SismaService;
use App\Jobs\EnvioOrdenFomag;
use App\Traits\ArchivosTrait;
use Carbon\Carbon;
use Exception;
use GuzzleHttp\Client;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\ValidationException;

class OrdenamientoService
{
    use ArchivosTrait;

    public function __construct(
        protected OrdenamientoRepository             $ordenamientoRepository,
        protected DireccionamientoService            $direccionamientoService,
        protected Consulta                           $consultaModel,
        protected OrdenInteroperabilidadService      $ordenInteroperabilidadService,
        protected CobroServicioRepository $cobroServicioRepository,
        protected ContratoService $contratoService,
        protected GestionOrdenPrestadorRepository $gestionOrdenPrestadorRepository,
        private readonly ConsultaRepository          $consultaRepository,
        private readonly BodegaRepRepository         $bodegaRepRepository,
        private readonly BodegaRepository            $bodegaRepository,
        private readonly CodesumiRepository          $codesumiRepository,
        private readonly ProgramasFarmaciaRepository $programasFarmaciaRepository,
        private readonly Cie10Repository             $cie10Repository,
        private readonly OrdenRepository $ordenRepository,
        private readonly OrdenArticuloIntrahospitalarioRepository $ordenArticuloIntrahospitalarioRepository,
        private readonly OrdenProcedimientoRepository $ordenProcedimientoRepository,
        private readonly CupRepository $cupRepository,
        private readonly CambiosOrdenesRepository $cambiosOrdenesRepository,
        private readonly OrdenCodigoPropioRepository $ordenCodigoPropioRepository,
        private readonly CodigoPropioRepository $codigoPropioRepository,
        protected FomagHttp $fomagHttp,
        protected SismaService $sismaService,
        protected DientesOrdenProcedimiento $dientesOrdenProcedimientos
    ) {}

    /**
     * Valida que las cantidades solicitadas no excedan las cantidades máximas permitidas.
     *
     * @param array $articulos Lista de artículos a validar.
     * @throws \Exception Si alguna cantidad solicitada excede la cantidad máxima permitida.
     */
    private function validarCantidades(array $articulos): void
    {
        foreach ($articulos as $articulo) {
            $codesumiId = $articulo["articulo"]["codesumi"]["id"];
            $codesumi   = Codesumi::find($codesumiId);

            if (!$codesumi) {
                throw new \Exception("No se encontró el medicamento con ID {$codesumiId}");
            }

            $cantidadSolicitada = intval($articulo["cantidadMedico"]);
            $cantidadMaxima     = intval($codesumi->cantidad_maxima_orden);

            if ($cantidadSolicitada > $cantidadMaxima) {
                throw new \Exception("Cantidad no permitida para el medicamento {$codesumi->nombre}, " . "la cantidad máxima es {$cantidadMaxima} y se intentó ordenar {$cantidadSolicitada}");
            }
        }
    }

    /**
     * Crea una nueva orden de medicamentos.
     *
     * @param int $consultaId ID de la consulta asociada a la orden.
     * @param int $numeroActual Número actual en la paginación.
     * @param int $totalMeses Total de meses para la paginación.
     * @param string $fechaVigencia Fecha de vigencia de la orden en formato 'Y-m-d'.
     * @return Orden La orden creada.
     * @author kobatime
     */
    protected function crearOrdenMedicamento(int $consultaId, int $numeroActual, int $totalMeses, string $fechaVigencia): Orden
    {
        $orden = new Orden();
        $orden->tipo_orden_id = 1;
        $orden->consulta_id = $consultaId;
        $orden->user_id = auth()->id();
        $orden->estado_id = 1;
        $orden->paginacion = "{$numeroActual}/{$totalMeses}";
        $orden->fecha_vigencia = $fechaVigencia;

        $orden->save();

        return $orden;
    }

    /**
     * Determina el estado de un medicamento basado en su parametrización y los niveles de ordenamiento del usuario.
     * @param CodesumiEntidad|null $parametrizacion La parametrización específica del medicamento para la entidad del afiliado.
     * @param array $niveles Los niveles de ordenamiento del usuario autenticado.
     * @return int El estado determinado del medicamento.
     * @author kobatime
     */
    private function determinarEstadoMedicamentos($parametrizacion, array $niveles, Afiliado $afiliado): int
    {
        //Si requiere MIPRES, siempre prevalece
        // if ($parametrizacion->requiere_mipres) {
        //     return EstadoOrdenMedicamentos::valor('REQUIERE_MIPRES');
        // }

        // Si pertenece a entidad  FOMAG
        if ($afiliado->entidad_id == 1) {
            if ($parametrizacion->requiere_autorizacion) {
                return EstadoOrdenMedicamentos::valor('REQUIERE_AUTORIZACION');
            }
            return EstadoOrdenMedicamentos::valor('ACTIVO');
        }

        // Caso por defecto según niveles
        $nivel = intval($parametrizacion->nivel_ordenamiento);
        $maxNivel = max($niveles);

        return $nivel > $maxNivel ? EstadoOrdenMedicamentos::valor('REQUIERE_AUTORIZACION') : EstadoOrdenMedicamentos::valor('ACTIVO');
    }


    /**
     * Calcula la cantidad mensual de un artículo basado en su dosis, frecuencia, duración y unidad de tiempo.
     *
     * @param array $articulo Datos del artículo que incluyen dosis, frecuencia, duración y unidad de tiempo.
     * @return int Cantidad mensual calculada.
     * @throws \Exception Si los valores de dosis, frecuencia o duración son menores o iguales a 0.
     * @author kobatime
     */
    private function calcularCantidad(array $articulo): int
    {
        $dosis    = (float) $articulo["dosis"];
        $frecuencia = intval($articulo["frecuencia"]);
        $duracion   = intval($articulo["duracion"]);
        $unidad     = $articulo["tiempo"];

        if ($frecuencia <= 0 || $dosis <= 0 || $duracion <= 0) {
            throw new \Exception("Los valores de dosis, frecuencia y duración deben ser mayores a 0.");
        }

        if ($unidad === "Horas") {
            // Cálculo cuando el medicamento es horario
            return (int) round((24 / $frecuencia) * $dosis * $duracion);
        }

        // Cálculo estándar (días, semanas, meses)
        return (int) round(($duracion / $frecuencia) * $dosis);
    }

    /**
     * Procesa los artículos de una orden.
     *
     * @param Orden $orden
     * @param array $articulos
     * @param int $mesActual
     * @param array $niveles
     * @param Afiliado $afiliado
     * @param int $idConsulta
     * @return void
     * @author kobatime
     */
    private function procesarArticulos(Orden $orden, array $articulos, int $mesActual, array $niveles, Afiliado $afiliado, int $idConsulta): void
    {

        $codesumiIds = array_column(array_column($articulos, 'articulo'), 'codesumi_id');
        $codesumis = Codesumi::whereIn('id', $codesumiIds)->get()->keyBy('id');

        $parametrizaciones = CodesumiEntidad::whereIn('codesumi_id', $codesumiIds)
            ->where('entidad_id', $afiliado->entidad_id)
            ->get()
            ->keyBy('codesumi_id');

        foreach ($articulos as $articulo) {

            if ($articulo['meses'] < $mesActual) {
                continue;
            }

            $codesumiId = $articulo["articulo"]["codesumi"]["id"];
            $codesumi   = $codesumis[$codesumiId] ?? null;

            if (!$codesumi) {
                throw new \Exception("No se encontró el medicamento con ID {$codesumiId}");
            }

            // Determinar estado del artículo
            $parametrizacion = $parametrizaciones[$codesumiId] ?? null;
            $estado = $this->determinarEstadoMedicamentos($parametrizacion, $niveles, $afiliado);

            // Calcular fecha vigencia (la hereda de la orden)
            $fechaVigencia = $orden->fecha_vigencia;

            // Calcular cantidad
            $cantidad = $this->calcularCantidad($articulo);

            // Crear y guardar el artículo de la orden
            $nuevoArticulo = new OrdenArticulo();
            $nuevoArticulo->orden_id = $orden->id;
            $nuevoArticulo->codesumi_id = $codesumiId;
            $nuevoArticulo->dosis = $articulo["dosis"];
            $nuevoArticulo->frecuencia = $articulo["frecuencia"];
            $nuevoArticulo->unidad_tiempo = $articulo["tiempo"];
            $nuevoArticulo->duracion = $articulo["duracion"];
            $nuevoArticulo->meses = $articulo["meses"];
            $nuevoArticulo->dosificacion_medico = $articulo["descripcion"];
            $nuevoArticulo->cantidad_mensual = $cantidad;
            $nuevoArticulo->cantidad_mensual_disponible = $articulo["cantidadMedico"];
            $nuevoArticulo->cantidad_medico = $articulo["cantidadMedico"];
            $nuevoArticulo->observacion = $articulo["observacion"];
            $nuevoArticulo->fecha_vigencia = $fechaVigencia;
            $nuevoArticulo->estado_id = $estado;
            $nuevoArticulo->rep_id = $this->calcularDireccionamientoFarmacia($idConsulta, $codesumiId);
            $nuevoArticulo->save();
        }
    }


    public function generarOrden(int $idConsulta, $tipo, $request)
    {
        $niveles = auth()->user()->getNivelesOrdenamiento();
        switch (intval($tipo)) {
            case 1:
                $mayorMes = max(array_column($request, 'meses'));
                $consulta = Consulta::select('afiliado_id')->find($idConsulta);
                if (!$consulta) {
                    throw new \Exception("La consulta con ID $idConsulta no fue encontrada.");
                }
                $afiliado = Afiliado::find($consulta->afiliado_id);
                if (!$afiliado) {
                    throw new \Exception("El afiliado con ID {$consulta->afiliado_id} no fue encontrado.");
                }

                DB::transaction(function () use ($request, $idConsulta, $mayorMes, $niveles, $afiliado) {
                    $this->validarCantidades($request);

                    $siguienteVigencia = Carbon::now()->format('Y-m-d');

                    for ($i = 1; $i <= $mayorMes; $i++) {
                        $orden = $this->crearOrdenMedicamento($idConsulta, $i, $mayorMes, $siguienteVigencia);
                        $this->procesarArticulos($orden, $request, $i, $niveles, $afiliado, $idConsulta);
                        $siguienteVigencia = Carbon::parse($orden->fecha_vigencia)->addDays(28)->format('Y-m-d');
                    }
                });
                break;
            case 2:
                $consulta = $this->consultaRepository->obtenerConsulta($idConsulta);

                if (!$consulta) {
                    throw new \Exception("La consulta con ID $idConsulta no fue encontrada.");
                }

                if (!$consulta->afiliado) {
                    throw new \Exception("La consulta no tiene un afiliado asociado.");
                }

                $this->validacionesServicio($request, $consulta->afiliado);
                $nuevaOrden = $this->crearOrden($idConsulta);
                $nuevoProcedimiento = $this->procesarProcedimientos($nuevaOrden, $consulta->afiliado, $request, $niveles);
                EnvioOrdenFomag::dispatch($nuevaOrden, Auth::id())
                    ->onQueue('interoperabilidad');

                return $nuevaOrden;
                break;
            case 3:
                $fechaCalculada = date('Y-m-d');
                foreach ($request['codeSumiEsquemaSeleccionado'] as $articulo) {
                    if (isset($articulo['dias_aplicacion'])) {
                        $numeroDias = explode(',', $articulo['dias_aplicacion']);
                        foreach ($numeroDias as $numerodia) {
                            $nuevaOrden = Orden::where('tipo_orden_id', $tipo)
                                ->where('consulta_id', $idConsulta)
                                ->where('nombre_esquema', $request['nombre_esquema'])
                                ->where('ciclo', $request['ciclo'])
                                ->where('dia', $numerodia)->where('estado_id', 1)->first();

                            if (!$nuevaOrden) {
                                $nuevaOrden = Orden::create([
                                    'tipo_orden_id' => 3,
                                    'consulta_id' => intval($idConsulta),
                                    'user_id' => auth()->user()->id,
                                    'paginacion' => $request['ciclo'] . '/' . $request['ciclo_total'],
                                    'estado_id' => 1,
                                    'nombre_esquema' => $request['nombre_esquema'],
                                    'ciclo' => $request['ciclo'],
                                    'dia' => $numerodia,
                                    'ciclo_total' => $request['ciclo_total'],
                                    'frecuencia_repeticion' => $request['frecuencia_repeticion'],
                                    'biografia' => $request['biografia'],
                                ]);
                            } else {
                                $nuevaOrden->update([
                                    'user_id' => auth()->user()->id,
                                    'estado_id' => 1,
                                    'paginacion' => $request['ciclo'] . '/' . $request['ciclo_total'],
                                    'ciclo' => $request['ciclo'],
                                    'dia' => $numerodia,
                                    'ciclo_total' => $request['ciclo_total'],
                                    'frecuencia_repeticion' => $request['frecuencia_repeticion'],
                                    'biografia' => $request['biografia'],
                                ]);
                            }

                            $orden_medicamento = OrdenArticulo::where('orden_id', $nuevaOrden->id)->where('codesumi_id', $articulo['id'])->first();
                            if (isset($orden_medicamento)) {
                                continue;
                            }

                            OrdenArticulo::create([
                                'orden_id' => $nuevaOrden->id,
                                'codesumi_id' => $articulo['id'],
                                'estado_id' => 3,
                                'dosis' => round(intval($articulo['dosis'])),
                                'frecuencia' => 1,
                                'unidad_tiempo' => $articulo['frecuencia'],
                                'cantidad_mensual' => round(intval($articulo['dosis_formulada'])),
                                'cantidad_mensual_disponible' => round(intval($articulo['dosis_formulada'])),
                                'cantidad_medico' => round(intval($articulo['dosis_formulada'])),
                                'meses' => 1,
                                'observacion' => $articulo['observaciones'],
                                'duracion' => $request['ciclo_total'],
                                'fecha_vigencia' => $fechaCalculada
                            ]);
                        }
                    } else {
                        $mayorMes = max(array_column($request['codeSumiEsquemaSeleccionado'], 'meses'));
                        $fechaCalculada = date('Y-m-d');
                        for ($i = 1; $i <= $mayorMes; $i++) {
                            $nuevaOrden = new Orden();
                            $nuevaOrden->tipo_orden_id = 3;
                            $nuevaOrden->consulta_id = intval($idConsulta);
                            $nuevaOrden->user_id = auth()->user()->id;
                            $nuevaOrden->estado_id = 1;
                            $nuevaOrden->paginacion = $i . '/' . $mayorMes;
                            $nuevaOrden->save();
                            foreach ($request['codeSumiEsquemaSeleccionado'] as $articulo) {
                                if (isset($articulo["articulo"]["id"])) {
                                    $nuevoArticulo = new OrdenArticulo();
                                    $nuevoArticulo->orden_id = $nuevaOrden->id;
                                    $nuevoArticulo->codesumi_id = $articulo["articulo"]["id"];
                                    $nuevoArticulo->dosis = $articulo["dosis"];
                                    $nuevoArticulo->frecuencia = $articulo["frecuencia"];
                                    $nuevoArticulo->unidad_tiempo = $articulo["tiempo"];
                                    $nuevoArticulo->duracion = $articulo["duracion"];
                                    $nuevoArticulo->meses = $articulo["meses"];
                                    $cantidad = 0;
                                    if ($articulo["tiempo"] == "Horas") {
                                        $cantidad = round((24 / intval($articulo["frecuencia"])) * intval($articulo["dosis"]) * intval($articulo["duracion"]));
                                    } else {
                                        $cantidad = round((intval($articulo["duracion"]) / intval($articulo["frecuencia"])) * intval($articulo["dosis"]));
                                    }
                                    $nuevoArticulo->cantidad_mensual = $cantidad;
                                    $nuevoArticulo->cantidad_mensual_disponible = $articulo["cantidadMedico"];
                                    $nuevoArticulo->cantidad_medico = $articulo["cantidadMedico"];
                                    $nuevoArticulo->observacion = $articulo["observaciones"];
                                    $nuevoArticulo->fecha_vigencia = $fechaCalculada;
                                    $estado = 1;
                                    if ($articulo["articulo"]["codesumi"]["requiere_autorizacion"] == 1 || intval($articulo["articulo"]["nivel_ordenamiento"]) > max($niveles)) {
                                        $estado = 3;
                                    }
                                    $nuevoArticulo->estado_id = $estado;
                                    $nuevoArticulo->save();
                                }
                            }
                            $siguienteVigencia = date("Y-m-d", strtotime($fechaCalculada . "+ 28 days"));
                            $fechaCalculada = $siguienteVigencia;
                        }
                    }
                }
            // no break
            case 4:
                // Otros Servicios (Códigos Propios)
                $consulta = Consulta::find($idConsulta);

                foreach ($request as $codigoPropio) {
                    $cupPropio = CodigoPropio::where('id', $codigoPropio['codigoPropio']['id'])->first();
                    if ($cupPropio['cantidad_max_ordenamiento'] < $codigoPropio['cantidad']) {
                        return response()->json([
                            'mensaje' => 'Cantidad no permitida para el servicio ' . $cupPropio['CodigoNombre'] . ', la cantidad máxima es de ' . $cupPropio['cantidad_max_ordenamiento'],
                            'type' => 'error'
                        ], 400);
                    }
                }

                $nuevaOrden = new Orden();
                $nuevaOrden->tipo_orden_id = 3;
                $nuevaOrden->consulta_id = intval($idConsulta);
                $nuevaOrden->user_id = auth()->user()->id;
                $nuevaOrden->estado_id = 1;
                $nuevaOrden->paginacion = null;
                $nuevaOrden->save();

                $idsConEstado3 = [
                    79,
                    77,
                    78,
                    76,
                    279,
                    288,
                    80,
                    294,
                    299,
                    296,
                    323,
                    291,
                    320,
                    290,
                    278,
                    284,
                    280,
                    281,
                    282,
                    285,
                    283,
                    286,
                    216,
                    287,
                    318,
                    319,
                    302,
                    374,
                    212,
                    371,
                    316,
                    322,
                    325,
                    321,
                    324,
                    326,
                    327,
                    328,
                    304,
                    303,
                    306,
                    293,
                    305,
                    342,
                    344,
                    343,
                    351,
                    348,
                    289,
                    292,
                    295,
                    298,
                    300,
                    301,
                    308,
                    346,
                    341,
                    345,
                    349,
                    307,
                    297,
                    309,
                    310,
                    311,
                    315,
                    317,
                    314,
                    75,
                    375
                ];

                foreach ($request as $codigoPropio) {
                    $nuevaOrdenCodigo = new OrdenCodigoPropio();
                    $nuevaOrdenCodigo->orden_id = $nuevaOrden->id;
                    $nuevaOrdenCodigo->codigo_propio_id = $codigoPropio['codigoPropio']['id'];
                    $nuevaOrdenCodigo->cantidad = $codigoPropio['cantidad'];
                    $nuevaOrdenCodigo->fecha_vigencia = $codigoPropio['fechaVigencia'];
                    $nuevaOrdenCodigo->observacion = $codigoPropio['observacion'];
                    $nuevaOrdenCodigo->estado_id_gestion_prestador = 50;

                    $id = $codigoPropio['codigoPropio']['id'];
                    $nuevaOrdenCodigo->estado_id = in_array($id, $idsConEstado3)
                        ? 3
                        : 1;

                    $direccionamiento = $this->direccionamientoService
                        ->direccionamientoOrdenesPropios($nuevaOrdenCodigo, $codigoPropio['rep']['id']);
                    $nuevaOrdenCodigo->rep_id = $direccionamiento
                        ? $direccionamiento->direccionamiento_id
                        : null;

                    $nuevaOrdenCodigo->save();

                    $this->contratoService->calcularValorServicio($nuevaOrdenCodigo->id, 4);
                }
                return response()->json([
                    'mensaje' => 'Ordenamiento cargado con éxito',
                    'type' => 'success'
                ], 200);

                break;
        }
    }

    protected function validacionesServicio(array $request, $afiliado)
    {
        foreach ($request as $item) {
            // Verifica que el procedimiento tenga un ID válido
            if (!isset($item['procedimiento']['id'])) {
                throw new \Exception('Uno de los procedimientos no tiene un ID válido.');
            }

            // Obtiene valores del procedimiento actual
            $cupId = $item['procedimiento']['id'];                         // ID del CUPS
            $codigoCup = $item['procedimiento']['codigo'] ?? 'DESCONOCIDO'; // Código (si no existe, asigna 'DESCONOCIDO')
            $cantidadSolicitada = (int) $item['cantidad'];                // Cantidad solicitada
            $fechaFin = $item['fechaVigencia'];                      // Fecha de vigencia final

            $cupEntidad = $this->cupRepository->consultarCupEntidad($item['procedimiento']['id'], $afiliado['entidad_id']);

            if (!$cupEntidad) {
                throw new \Exception("El servicio con código $codigoCup no está parametrizado para la entidad.");
            }

            // Extrae límites desde la configuración de cup_entidad
            $cantidadMaxima = (int) $cupEntidad->cantidad_max_ordenamiento;
            $periodicidadDias = (int) $cupEntidad->periodicidad;
            $fechaInicio = date('Y-m-d', strtotime("-{$periodicidadDias} days", strtotime($fechaFin)));

            // Consulta cuántos procedimientos iguales se han ordenado en ese rango de fechas
            $sumaOrdenesEnRango = $this->ordenProcedimientoRepository->getCantidadProcedimientosEnRango($afiliado['id'], $cupId, $fechaInicio, $fechaFin);

            // Si ya hay ordenamientos previos, validar la suma
            if ($sumaOrdenesEnRango + $cantidadSolicitada > $cantidadMaxima && $periodicidadDias > 0) {
                throw new \Exception("El servicio con código $codigoCup sobrepasa la cantidad máxima ($cantidadMaxima) en un periodo de $periodicidadDias días.");
            }

            // Si no hay históricos, validar que la cantidad actual no supere el máximo
            if ($cantidadSolicitada > $cantidadMaxima) {
                throw new \Exception("El servicio con código $codigoCup sobrepasa la cantidad máxima ($cantidadMaxima) en un periodo de $periodicidadDias días.");
            }
        }
        return ['valido' => true, 'mensaje' => ''];
    }

    protected function procesarProcedimientos($nuevaOrden, $afiliado, $procedimientos, $niveles)
    {
        foreach ($procedimientos as $procedimiento) {
            $cup = $this->cupRepository->consultarCupEntidad($procedimiento['procedimiento']['id'], $afiliado['entidad_id']);

            if (!$cup) {
                throw new \Exception("El cups no se encuntra parametrizado para la entidad el paciente");
            }

            if ($cup->cantidad_max_ordenamiento < $procedimiento['cantidad']) {
                throw new \Exception('Cantidad no permitida para el cup ' . $cup->cup->nombre . '. Máxima: ' . $cup->cantidad_max_ordenamiento);
            }

            $nuevoProcedimiento = $this->crearOrdenProcedimiento($nuevaOrden, $cup, $procedimiento, $niveles);
            $direccionamiento = $this->direccionamientoService->direccionamientoOrdenes($nuevoProcedimiento, $procedimiento['rep']['id']);
            $nuevoProcedimiento->rep_id = $direccionamiento ? $direccionamiento->direccionamiento_id : null;
            $nuevoProcedimiento->save();

            $this->contratoService->calcularValorServicio($nuevoProcedimiento->id, 2);
        }

        return true;
    }

    protected function crearOrdenProcedimiento($orden, $cup, $data, $niveles)
    {
        return new OrdenProcedimiento([
            'orden_id' => $orden->id,
            'cup_id' => $cup->cup_id,
            'cantidad' => $data['cantidad'],
            'fecha_vigencia' => $data['fechaVigencia'],
            'observacion' => $data['observacion'],
            'estado_id' => $this->determinarEstado($cup, $niveles),
            'estado_id_gestion_prestador' => 50,
        ]);
    }

    protected function crearOrden(int $idConsulta)
    {
        $nuevaOrden = new Orden();
        $nuevaOrden->tipo_orden_id = 2; // Tipo de orden para servicios
        $nuevaOrden->consulta_id = intval($idConsulta);
        $nuevaOrden->user_id = auth()->user()->id;
        $nuevaOrden->estado_id = 1; // Estado inicial
        $nuevaOrden->paginacion = null; // Paginación no aplica para servicios
        $nuevaOrden->save();

        return $nuevaOrden;
    }

    protected function determinarEstado($cup, $niveles)
    {
        if ($cup->requiere_auditoria == 1 || intval($cup->nivel_ordenamiento) > max($niveles)) {
            return 3;
        }
        return 1;
    }

    public function detalleOrdenamientoPorConsulta($consulta)
    {

        $medicamentos = [];
        $servicios = [];
        $codigosPropios = [];
        $ordenMedicamento = $this->ordenamientoRepository->ordenamientoMedicamento($consulta);
        $ordenServicios = $this->ordenamientoRepository->ordenamientoServicios($consulta);
        $ordenCodigosPropios = $this->ordenamientoRepository->ordenamientoCodigosPropios($consulta);

        if ($ordenMedicamento) {
            $medicamentos = OrdenArticulo::select('orden_articulos.*', 'o.paginacion')->selectRaw("'medicamento' as tipo")->selectRaw("'1' as tipoOrden")->with(['codesumi', 'estado'])->join('ordenes as o', 'o.id', 'orden_articulos.orden_id')->whereIn('orden_articulos.orden_id', $ordenMedicamento)->get()->toArray();
        }
        if ($ordenServicios) {
            $servicios = OrdenProcedimiento::select('orden_procedimientos.*', 'o.paginacion')->with(['cup', 'estado'])->selectRaw("'servicio' as tipo")->selectRaw("'2' as tipoOrden")->join('ordenes as o', 'o.id', 'orden_procedimientos.orden_id')->whereIn('orden_procedimientos.orden_id', $ordenServicios)->get()->toArray();
        }
        if ($ordenCodigosPropios) {
            $codigosPropios = OrdenCodigoPropio::select('orden_codigo_propios.*', 'o.paginacion')->with(['codigoPropio.cup', 'estado'])->selectRaw("'codigoPropio' as tipo")->selectRaw("'3' as tipoOrden")->join('ordenes as o', 'o.id', 'orden_codigo_propios.orden_id')->whereIn('orden_codigo_propios.orden_id', $ordenCodigosPropios)->get()->toArray();
        }

        return array_merge($medicamentos, $servicios, $codigosPropios);
    }

    public function datosPrestador($servicio, $data)
    {
        $ordenProcedimiento = OrdenProcedimiento::find($servicio);

        $paciente = Afiliado::select(['afiliados.*'])
            ->join('consultas as cp', 'cp.afiliado_id', 'afiliados.id')
            ->join('ordenes as o', 'o.consulta_id', 'cp.id')
            ->where('o.id', $ordenProcedimiento->orden_id)
            ->first();


        if (isset($data['adjuntos'])) {
            $archivos = $data['adjuntos'];
            $ruta = 'adjuntosSoportes';
            if (sizeof($archivos) >= 1) {
                foreach ($archivos as $archivo) {
                    $nombreOriginal = $archivo->getClientOriginalName();
                    $nombre = $paciente['numero_documento'] . '/' . time() . $nombreOriginal;
                    $subirArchivo = $this->subirArchivoNombre($ruta, $archivo, $nombre, 'server37');
                }
            }
        }

        $ordenProcedimiento->update([
            'fecha_solicitada' => ($data['fecha_solicitada'] !== 'null' ? $data['fecha_solicitada'] : null),
            'fecha_sugerida' => ($data['fecha_sugerida'] !== 'null' ? $data['fecha_sugerida'] : null),
            'fecha_resultado' => ($data['fecha_resultado'] !== 'null' ? $data['fecha_resultado'] : null),
            'observaciones' => ($data['observaciones'] !== 'null' ? $data['observaciones'] : null),
            'fecha_cancelacion' => ($data['fecha_cancelacion'] !== 'null' ? $data['fecha_cancelacion'] : null),
            'cancelacion' => ($data['cancelacion'] !== 'null' ? $data['cancelacion'] : null),
            'causa' => ($data['causa'] !== 'null' ? $data['causa'] : null),
            'motivo' => ($data['motivo'] !== 'null' ? $data['motivo'] : null),
            'responsable' => $data['responsable'],
            'soportes' => (isset($data['adjuntos']) ? json_encode($subirArchivo) : null),
            'cirujano' => ($data['cirujano'] !== 'null' ? $data['cirujano'] : null),
            'especialidad' => ($data['especialidad'] !== 'null' ? $data['especialidad'] : null),
            'fecha_Preanestesia' => ($data['fecha_Preanestesia'] !== 'null' ? $data['fecha_Preanestesia'] : null),
            'fecha_cirugia' => ($data['fecha_cirugia'] !== 'null' ? $data['fecha_cirugia'] : null),
            'fecha_ejecucion' => ($data['fecha_ejecucion'] !== 'null' ? $data['fecha_ejecucion'] : null),
        ]);

        return 'exito';
    }

    public function direccionarOrden($data)
    {
        $campo_nombre = null;
        $campo_valor = null;

        if (isset($data->orden_procedimientos_id)) {
            OrdenProcedimiento::find($data->orden_procedimientos_id)->update([
                'rep_id' => $data->rep_id
            ]);
            $campo_nombre = 'orden_procedimiento_id';
            $campo_valor = $data->orden_procedimientos_id;
        } elseif (isset($data->orden_articulos_id)) {
            OrdenArticulo::find($data->orden_articulos_id)->update([
                'rep_id' => $data->rep_id
            ]);
            $campo_nombre = 'orden_articulo_id';
            $campo_valor = $data->orden_articulos_id;
        } elseif (isset($data->orden_codigo_propio_id)) {
            OrdenCodigoPropio::find($data->orden_codigo_propio_id)->update([
                'rep_id' => $data->rep_id
            ]);
            $campo_nombre = 'orden_codigo_propio_id';
            $campo_valor = $data->orden_codigo_propio_id;
        } else {
            return 'Error: No se proporcionó un ID válido';
        }

        CambiosOrdene::create([
            $campo_nombre => $campo_valor,
            'user_id' => Auth::id(),
            'accion' => 'Actualización de direccionamiento',
            'observacion' => 'Se realiza actualización de direccionamiento'
        ]);

        return 'Se ha actualizado el direccionamiento correctamente';
    }


    /**
     *
     */
    public function getHistorico($data)
    {
        $registros = null;

        // Validar si `orden_id` está definido y es numérico
        $orden_id = isset($data['orden_id']) && is_numeric($data['orden_id']) ? intval($data['orden_id']) : null;

        switch (intval($data['tipo'])) {
            case 1:
                $registros = OrdenArticulo::select([
                    'orden_articulos.id',
                    'orden_articulos.orden_id',
                    'orden_articulos.codesumi_id',
                    'orden_articulos.estado_id',
                    'orden_articulos.dosis',
                    'orden_articulos.frecuencia',
                    'orden_articulos.unidad_tiempo',
                    'orden_articulos.duracion',
                    'orden_articulos.meses',
                    'orden_articulos.cantidad_mensual',
                    'orden_articulos.cantidad_mensual_disponible',
                    'orden_articulos.cantidad_medico',
                    'orden_articulos.observacion',
                    'orden_articulos.fecha_vigencia',
                    'orden_articulos.autorizacion',
                    'orden_articulos.mipres',
                    'orden_articulos.created_at',
                    'orden_articulos.rep_id',
                    'orden_articulos.dosificacion_medico',
                    'o.paginacion',
                    'cs.codigo',
                    'cs.nombre',
                    'cs.via',
                    'formas_farmaceuticas.nombre as forma'
                ])
                    ->with([
                        'rep:id,nombre',
                        'cambioOrden',
                        'auditorias.user.operador',
                        'estado:id,nombre',
                        'orden.consulta.recomendacionConsulta',
                        'orden.consulta.afiliado',
                        'orden.funcionario.operador',
                        'cambioOrden' => function ($query) {
                            $query->with([
                                'rep:id,nombre',
                                'cup:id,nombre',
                                'user.operador',
                            ]);
                        },
                    ])
                    ->join('ordenes as o', 'o.id', '=', 'orden_articulos.orden_id')
                    ->join('consultas as c', 'c.id', '=', 'o.consulta_id')
                    ->join('afiliados as a', 'a.id', '=', 'c.afiliado_id')
                    ->join('codesumis as cs', 'cs.id', '=', 'orden_articulos.codesumi_id')
                    ->leftjoin('formas_farmaceuticas', 'formas_farmaceuticas.id', 'cs.forma_farmaceutica_id')
                    ->orderBy('orden_articulos.created_at', 'desc');

                if (isset($data['documento'])) {
                    $registros->where('a.numero_documento', $data['documento']);
                }
                if (isset($orden_id)) {
                    $registros->where('orden_articulos.orden_id', $orden_id);
                }
                if (isset($data['fecha_vigencia_desde']) && isset($data['fecha_vigencia_hasta'])) {
                    $registros->whereBetween('orden_articulos.fecha_vigencia', [$data['fecha_vigencia_desde'], $data['fecha_vigencia_hasta']]);
                }
                if (isset($data['cs_nombre'])) {
                    $registros->where('cs.nombre', 'ilike', '%' . $data['cs_nombre'] . '%');
                }
                break;
            case 2:
                $registros = OrdenProcedimiento::select([
                    'orden_procedimientos.id',
                    'orden_procedimientos.cup_id',
                    'orden_procedimientos.orden_id',
                    'orden_procedimientos.rep_id',
                    'orden_procedimientos.estado_id',
                    'orden_procedimientos.cantidad',
                    'orden_procedimientos.valor_tarifa',
                    'orden_procedimientos.fecha_vigencia',
                    'orden_procedimientos.observacion',
                    'orden_procedimientos.created_at',
                    'orden_procedimientos.autorizacion',
                    'orden_procedimientos.estado_id_gestion_prestador',
                    'cp.codigo',
                    'cp.nombre',
                    'orden_procedimientos.cantidad_usada',
                    'orden_procedimientos.firma_paciente'
                ])->with([
                            'orden.consulta.afiliado',
                            'auditoria.user.operador',
                            'estado',
                            'estadoGestionPrestador',
                            'cambioOrden' => function ($query) {
                                $query->with([
                                    'rep:id,nombre',
                                    'cup:id,nombre',
                                    'user.operador',
                                ]);
                            },
                            'orden.consulta.recomendacionConsulta',
                            'orden.funcionario.operador'
                        ])
                    ->join('ordenes as o', 'o.id', 'orden_procedimientos.orden_id')
                    ->join('consultas as c', 'c.id', 'o.consulta_id')
                    ->join('afiliados as a', 'a.id', 'c.afiliado_id')
                    ->join('cups as cp', 'cp.id', 'orden_procedimientos.cup_id')
                    ->with('orden', 'rep')
                    ->orderBy('orden_procedimientos.created_at', 'desc');

                if (isset($data['documento'])) {
                    $registros->where('a.numero_documento', $data['documento']);
                }
                if (isset($orden_id)) {
                    $registros->where('orden_procedimientos.orden_id', $orden_id);
                }
                if (isset($data['fecha_vigencia_desde']) && isset($data['fecha_vigencia_hasta'])) {
                    $registros->whereBetween('orden_procedimientos.fecha_vigencia', [$data['fecha_vigencia_desde'], $data['fecha_vigencia_hasta']]);
                }
                if (isset($data['cp_nombre'])) {
                    $registros->where('cp.nombre', 'ilike', '%' . $data['cp_nombre'] . '%');
                }
                break;
            case 3:
                $registros = OrdenCodigoPropio::select([
                    'orden_codigo_propios.*',
                    'codpropio.codigo',
                    'codpropio.nombre',
                ])->with([
                            'estado',
                            'cambioOrden.rep',
                            'cambioOrden.user.operador',
                            'auditoria.user.operador',
                            'estadoGestionPrestador',
                            'cambioOrden' => function ($query) {
                                $query->with([
                                    'user.operador',
                                    'rep:id,nombre'
                                ]);
                            },
                        ])
                    ->join('ordenes as o', 'o.id', 'orden_codigo_propios.orden_id')
                    ->join('consultas as c', 'c.id', 'o.consulta_id')
                    ->join('afiliados as a', 'a.id', 'c.afiliado_id')
                    ->join('codigo_propios as codpropio', 'codpropio.id', 'orden_codigo_propios.codigo_propio_id')
                    ->with('orden.consulta.afiliado', 'rep', 'orden.funcionario.operador')
                    ->orderBy('orden_codigo_propios.created_at', 'desc');

                if (isset($data['documento'])) {
                    $registros->where('a.numero_documento', $data['documento']);
                }
                if (isset($orden_id)) {
                    $registros->where('orden_codigo_propios.orden_id', $orden_id);
                }
                break;
            case 4:
                $registros = DB::table('tipo_ordenes');
                break;
        }
        return isset($data['page']) ? $registros->paginate($data['cant']) : $registros->get();
    }

    /**
     * lista las ordenes por afiliado
     * @return Collection
     * @author David Peláez
     */
    public function listarOrdenesPorAfiliado($afiliado_id)
    {
        return Orden::whereHas('consulta', function ($query) use ($afiliado_id) {
            return $query->where('afiliado_id', $afiliado_id)
                ->where('tipo_orden_id', 1);
        })
            ->without('consulta')
            //->withCount('articulosActivos')
            ->orderBy('created_at', 'desc')
            ->get();
    }

    /**
     * lista las ordenes por afiliado
     * @return Collection
     * @author David Peláez
     * @modifiedBy jose vasquez 24 sep - 2025
     */
    public function listarOrdenesActivas($afiliado_id)
    {
        $hoy = Carbon::now()->format('Y-m-d') . ' 23:59:59.999';
        $cambio = Carbon::now()->subDays(31)->format('Y-m-d') . ' 00:00:00.000';

        return Orden::with([
            'consulta.afiliado:id',
            'articulos' => function ($q) use ($cambio, $hoy) {
                $q->where('estado_id', '<>', 34)
                    ->whereBetween('fecha_vigencia', [$cambio, $hoy])
                    ->select('id', 'orden_id', 'fecha_vigencia', 'estado_id');
            }
        ])
            ->whereHas('consulta.afiliado', function ($q) use ($afiliado_id) {
                $q->where('id', $afiliado_id);
            })
            ->whereHas('articulos', function ($q) use ($cambio, $hoy) {
                $q->where('estado_id', '<>', 34)
                    ->whereBetween('fecha_vigencia', [$cambio, $hoy]);
            })
            ->orderBy('created_at', 'desc')
            ->get();
    }

    /**
     * lista las ordenes por afiliado
     * @return Collection
     * @author David Peláez
     */
    public function listarOrdenesProximas($afiliado_id)
    {
        $hoy = Carbon::now();

        return Orden::with(['estado'])->whereHas('consulta', function ($query) use ($afiliado_id) {
            return $query->where('afiliado_id', $afiliado_id)->where('tipo_orden_id', 1);
        })
            ->where('fecha_vigencia', '>', $hoy->format('Y-m-d'))
            ->whereHas('articulosActivos')
            ->orderBy('created_at', 'desc')
            ->get();
    }

    /**
     * lista las ordenes con articulos pendientes por afiliado
     * @return Collection
     * @author David Peláez
     * Modificado por Thomas Restrepo
     */
    public function listarOrdenesPendientes($afiliado_id)
    {

        return Orden::whereHas('consulta', function ($query) use ($afiliado_id) {
            return $query->where('afiliado_id', $afiliado_id);
        })
            ->whereHas('articulos', function ($query) {
                return $query->whereIn('estado_id', [10, 18]);
            })
            ->get();
    }

    /**
     * lista los articulos por orden
     * @return Collection
     * @author David Peláez
     */
    public function listarArticulosPorOrden($orden_id, $estado)
    {
        return OrdenArticulo::with(['estado', 'codesumi'])
            ->where('orden_id', $orden_id)
            ->whereEstado($estado)
            ->orderBy('created_at', 'desc')
            ->get();
    }

    /**
     * lista los articulos activos por orden
     * @return Collection
     * @author Thomas Restrepo
     */
    public function listarArticulosActivosPorOrden($orden_id)
    {
        return OrdenArticulo::where('orden_id', $orden_id)
            // ->whereIn('estado_id', [1, 4])
            ->orderBy('created_at', 'desc')
            ->get();
    }

    /**
     * lista los articulos pendientes por orden
     * @return Collection
     * @author kobatime
     */
    public function listarArticulosPendientesPorOrden($orden_id)
    {

        //$arrayDeEstados = explode(',', $estados);

        return OrdenArticulo::with(['estado', 'codesumi'])
            ->where('orden_id', $orden_id)
            ->whereIn('orden_articulos.estado_id', [10, 18])
            ->orderBy('created_at', 'desc')
            ->get();
    }


    /**
     * lista los articulos por orden
     * @return Collection
     * @author David Peláez
     */
    public function listarArticulosPorAfiliado($afiliado_id, $estados)
    {

        //$arrayDeEstados = explode(',', $estados);

        return Movimiento::with('ordenArticulo', 'detalleMovimientos', 'bodegaOrigen')
            ->whereHas('ordenArticulo.orden.consulta', function ($query) use ($afiliado_id) {
                return $query->where('afiliado_id', $afiliado_id);
            })
            ->whereHas('ordenArticulo.orden', function ($query) {
                return $query->where('tipo_orden_id', 1);
            })
            ->orderBy('created_at', 'desc')
            ->get();
    }

    public function listarHorus1Activas($request)
    {
        $cliente = new Client(['verify' => false]);
        $respuesta = $cliente->get('https://sumimedical.horus-health.com/api/orden/getFormulasActivas?token=KMkm5PyrELKB2jnLMKyBgi8WgPwSNizSwwxJXBuY&Num_Doc=' . intval($request->Num_Doc));
        $data = json_decode($respuesta->getBody()->getContents(), true);

        return [
            'data' => $data,
        ];
    }

    public function transcripcionFormulas($request)
    {
        // dd($request);
        $consulta = Consulta::create([
            'finalidad' => 'No aplica',
            'afiliado_id' => $request->afiliado_id,
            'estado_id' => 30,
            'tipo_consulta_id' => 1,
        ]);

        $transcripcion = Transcripcione::create([
            'consulta_id' => $consulta->id,
            'afiliado_id' => $request->afiliado_id,
            'ambito' => 'Ambulatorio',
            'medico_ordeno' => auth()->user()->id,
            'finalidad' => 'No aplica',
            'observaciones' => 'Transcripción Horus 1',
            'tipo_transcripcion' => 'Interna',
            'user_id' => auth()->user()->id,
        ]);

        $orden = Orden::create([
            'tipo_orden_id' => 1,
            'consulta_id' => $consulta->id,
            'user_id' => auth()->user()->id,
            'estado_id' => 1,
            'paginacion' => '1/1',
            'fecha_vigencia' => Carbon::parse($request->Fechaorden)->format('Y-m-d')
        ]);

        $cliente = new Client(['verify' => false]);
        $respuesta = $cliente->get('https://sumimedical.horus-health.com/api/orden/getFormulasDetalle?token=KMkm5PyrELKB2jnLMKyBgi8WgPwSNizSwwxJXBuY&Orden_id=' . intval($request->id));
        $medicamentos = json_decode($respuesta->getBody()->getContents(), true);

        foreach ($medicamentos as $medicamento) {
            OrdenArticulo::create([
                'orden_id' => $orden->id,
                'codesumi_id' => (int) $medicamento['codesumi_id'],
                'dosis' => (int) $medicamento['Cantidadosis'],
                'frecuencia' => (int) $medicamento['Frecuencia'],
                'unidad_tiempo' => $medicamento['Unidadtiempo'],
                'duracion' => (int) $medicamento['Duracion'],
                'meses' => 1,
                'cantidad_mensual' => (int) $medicamento['Cantidadmensual'],
                'cantidad_mensual_disponible' => (int) $medicamento['Cantidadmensualdisponible'],
                'cantidad_medico' => (int) $medicamento['Cantidadpormedico'],
                'observacion' => $medicamento['Observacion'],
                'estado_id' => 1,
                'fecha_vigencia' => $medicamento['Fechaorden'],
            ]);
        }

        $cliente = new Client(['verify' => false]);
        $respuesta = $cliente->get('https://sumimedical.horus-health.com/api/orden/getFormulasActualizar?token=KMkm5PyrELKB2jnLMKyBgi8WgPwSNizSwwxJXBuY&Orden_id=' . intval($request->id));
        $medicamentos = json_decode($respuesta->getBody()->getContents(), true);

        return true;
    }

    // public function buscarAlergico(Request $request)
    // {
    //    if($request->medicamento['descripcion_atc'] != null){
    //         $alergico = AntecedentesFarmacologico::select('antecedente_farmacologicos.observacionAlergia')
    //         ->join('detallearticulos','detallearticulos.id','antecedente_farmacologicos.detallearticulo_id')
    //         ->where('antecedente_farmacologicos.estado_id',1)
    //         ->where('antecedente_farmacologicos.paciente_id',$request->paciente_id)
    //         ->where('detallearticulos.Descripcion_Atc',$request->medicamento['descripcion_atc'])->first();

    //         if($alergico == null){
    //             $alergico = false;
    //         }
    //    }
    //    else{
    //     $alergico = false;
    //    }

    //     return response()->json($alergico,200);
    // }


    /**
     * Lista los movimientos de la dispensacion del afiliado
     * @param int $afiliadoId
     * @param array $request
     * @return Collection
     * @author Thomas Restrepo
     */
    public function listarMovimientosDispensacion($afiliadoId, $request): Collection
    {

        $fechaInicio = $request['fechaInicio'];
        $fechaFin = $request['fechaFin'];

        $ordenId = $request['ordenId'];

        $codesumiId = $request['codesumiId'];

        return Movimiento::with('orden.consulta.afiliado.tipoDocumento', 'ordenArticulo', 'detalleMovimientos', 'bodegaOrigen')
            ->whereHas('ordenArticulo.orden.consulta', function ($query) use ($afiliadoId) {
                return $query->where('afiliado_id', $afiliadoId);
            })
            ->whereHas('ordenArticulo.orden', function ($query) {
                return $query->where('tipo_orden_id', 1);
            })
            ->when($fechaInicio != null && $fechaFin != null, function ($query) use ($fechaInicio, $fechaFin) {
                return $query->whereBetween('created_at', [$fechaInicio, $fechaFin]);
            })
            ->when($ordenId != null, function ($query) use ($ordenId) {
                return $query->whereHas('ordenArticulo.orden', function ($query) use ($ordenId) {
                    return $query->where('id', $ordenId);
                });
            })
            ->when($codesumiId != null, function ($query) use ($codesumiId) {
                return $query->whereHas('ordenArticulo', function ($query) use ($codesumiId) {
                    return $query->where('codesumi_id', $codesumiId);
                });
            })
            ->whereNotIn('tipo_movimiento_id', [15, 17])
            ->orderBy('created_at', 'desc')
            ->get();
    }

    public function actualizarFechaVigencia($ordenId, $request)
    {
        // Obtener el ID de la consulta correspondiente a la orden
        $consultaId = Orden::find($ordenId)->consulta_id;

        // Obtener la orden seleccionada
        $ordenSeleccionada = Orden::find($ordenId);

        // Obtener la paginación de la orden seleccionada
        $paginacionSeleccionada = $ordenSeleccionada->paginacion;

        // Fecha enviada en el request
        $nuevaFecha = Carbon::parse($request['fecha_vigencia']);

        // Obtener la fecha de vigencia original de la orden seleccionada
        $fechaVigenciaOriginal = Carbon::parse($ordenSeleccionada->fecha_vigencia);

        // Calcular la diferencia de días entre la fecha original y la nueva fecha
        $diferenciaDias = $fechaVigenciaOriginal->diffInDays($nuevaFecha);

        $hoy = Carbon::now();

        // Obtener las órdenes próximas asociadas a esa consulta y con paginación igual o mayor a la seleccionada
        $ordenes = Orden::where('consulta_id', $consultaId)
            ->where('paginacion', '>=', $paginacionSeleccionada)
            ->where('fecha_vigencia', '>', $hoy->format('Y-m-d'))
            ->get();

        // Actualizar las fechas de vigencia de las órdenes
        foreach ($ordenes as $orden) {
            // Si es la orden seleccionada, asignar directamente la nueva fecha
            if ($orden->id === $ordenId) {
                $orden->fecha_vigencia = $nuevaFecha;
            } else {
                // Para las demás órdenes, restar los días
                $nuevaFechaVigenciaOrden = Carbon::parse($orden->fecha_vigencia)->subDays($diferenciaDias);
                $orden->fecha_vigencia = $nuevaFechaVigenciaOrden;
            }

            $orden->save();

            // Obtener los artículos relacionados con esta orden y actualizar su fecha de vigencia
            foreach ($orden->articulos as $articulo) {
                $articulo->fecha_vigencia = $orden->fecha_vigencia; // Sincronizar la fecha del artículo con la de la orden
                $articulo->save();
            }
        }

        return $ordenes;
    }

    public function cobrarOrden($data)
    {

        $cobro = OrdenProcedimiento::where('id', $data->orden_servicio_id)->first();

        $cobro->update([
            'estado_id' => 1,
        ]);

        return $cobro;
    }

    public function actualizarEstado($id, $tipo, $estado_id, $observacion)
    {
        if ($tipo === 2) {
            $orden = OrdenProcedimiento::find($id);
            $campo_id = 'orden_procedimiento_id';
        } elseif ($tipo === 1) {
            $orden = OrdenArticulo::find($id);
            $campo_id = 'orden_articulo_id';
        } elseif ($tipo === 3) {
            $orden = OrdenCodigoPropio::find($id);
            $campo_id = 'id';
        } else {
            return [
                'message' => 'Tipo de orden no válido'
            ];
        }

        if (!$orden) {
            return [
                'message' => 'Orden no encontrada'
            ];
        }

        // Actualizar el estado
        $orden->estado_id = $estado_id;
        $orden->save();
        CambiosOrdene::create([
            $campo_id => $orden->id,
            'user_id' => Auth::id(),
            'accion' => 'Actualización de estado',
            'observacion' => $observacion
        ]);
        return [
            'mensaje' => 'Estado actualizado y registro de cambio guardado exitosamente'
        ];
    }

    public function cambiarAutorizacionMipres($datos, $articulo)
    {

        $aditoria = Auditoria::create([
            'orden_articulo_id' => $datos['orden_articulo_id'],
            'user_id' => auth()->user()->id,
            'observaciones' => $datos['observacion']
        ]);
        $articulo->update([
            'estado_id' => 4
        ]);

        return $aditoria;
    }

    public function cambioDireccionamientoMasivo(array $ordenes, int $repsId)
    {
        $this->ordenamientoRepository->guardarAuditoriaDireccionamiento($ordenes);

        switch ($ordenes['tipo']) {
            case 1:
                return OrdenArticulo::whereIn('id', $ordenes['seleccionados'])->update(['rep_id' => $repsId]);
            case 2:
                return OrdenProcedimiento::whereIn('id', $ordenes['seleccionados'])->update(['rep_id' => $repsId]);

            case 3:
                return OrdenCodigoPropio::whereIn('id', $ordenes['seleccionados'])->update(['rep_id' => $repsId]);
        }
    }

    public function AutorizarOrdenArticulo(array $data, $id)
    {
        $autorizar = $this->ordenamientoRepository->AuditoriaOrdenArticulo($data);

        $autorizar = OrdenArticulo::where('id', $id)->update(['estado_id' => 4]);

        return $autorizar;
    }

    /**
     * envia una orden a fomag
     * @param Orden|int $orden
     */
    public function enviarFomag(Orden|int $orden)
    {
        if (!$orden instanceof Orden) {
            $orden = Orden::where('id', $orden)->firstOrFail();
        }

        if ($orden->enviado) {
            throw new Exception('Esta orden ya fue enviada a fomag', 422);
        }

        if ($orden->tipo_orden_id != 2) {
            throw new Exception('Esta orden no es de procedimiento', 422);
        }

        EnvioOrdenFomag::dispatch($orden, Auth::id())
            ->onQueue('interoperabilidad');

        return $orden;
    }


    public function firmaAfiliadoOrdenNegada($request)
    {
        $auditoria = Auditoria::findOrFail($request['auditoria']);
        $auditoria->update(['firma_electronica' => $request['firma']]);
        return $auditoria;
    }


    /**
     * Calcula el direciconamiento de una orden de medicamentos
     * @param int $consultaId
     * @param $codesumiId
     * @return int|null
     * @author Thomas
     */
    private function calcularDireccionamientoFarmacia(int $consultaId, $codesumiId): ?int
    {
        // Buscar el afiliado y su IPS
        $afiliado = $this->consultaRepository->buscar($consultaId)->afiliado;
        $ipsAfiliado = $afiliado->ips;

        if (!$ipsAfiliado) {
            return null;
        }

        // Si el afiliado es de Ferrocarriles se usa el direccionamiento para programas BÁSICO
        if ($afiliado->entidad_id === 3) {
            return $this->direccionarProgramaUnicoBasico($afiliado);
        }

        // Obtener las entidades asociadas al codesumi
        $codesumiEntidades = $this->codesumiRepository->buscar($codesumiId)->codesumiEntidad;

        if ($codesumiEntidades->isEmpty()) {
            return null;
        }

        // Buscar la entidad del codesumi que coincida con la entidad del afiliado
        $codesumiEntidad = $codesumiEntidades->where('entidad_id', $afiliado->entidad_id)->first();

        if (!$codesumiEntidad) {
            return null; // No hay una entidad que coincida con la del afiliado
        }

        // Obtener los programas de la entidad filtrada
        $programasCodesumi = $codesumiEntidad->programaCodesumi;

        if ($programasCodesumi->isEmpty()) {
            return null;
        }

        // Extraer los IDs de los programas
        $programasIds = $programasCodesumi->pluck('id')->toArray();

        // Identificar el escenario según los programas del codesumiEntidad
        switch (true) {
            case count($programasIds) === 1 && in_array(1, $programasIds):
                // Solo tiene el programa BÁSICO
                return $this->direccionarProgramaUnicoBasico($afiliado);

            case count($programasIds) === 1 && !in_array(1, $programasIds):
                // Solo tiene un programa que no es BÁSICO
                return $this->direccionarProgramaUnicoNOBasico($programasIds, $afiliado);

            case count($programasIds) > 1:
                // Tiene varios programas
                return $this->direccionamientoVariosProgramas($programasIds, $afiliado, $consultaId);

            default:
                return null;
        }
    }

    /**
     * Direccionamiento para el programa BÁSICO
     * @param Afiliado $afiliado
     * @return int|null
     * @author Thomas
     */
    private function direccionarProgramaUnicoBasico(Afiliado $afiliado): ?int
    {
        // Buscar en BodegasReps por la IPS del afiliado
        $bodegasReps = $this->bodegaRepRepository->buscarPorRepId($afiliado->ips_id);

        if (!$bodegasReps) {
            return null;
        }

        return $this->bodegaRepository->buscar($bodegasReps->bodega_id)->rep_id ?? null;
    }

    /**
     * Direccionamiento para el programa diferente al BÁSICO
     * @param array $programas
     * @param Afiliado $afiliado
     * @return int|null
     * @author Thomas
     */
    private function direccionarProgramaUnicoNOBasico(array $programas, Afiliado $afiliado): ?int
    {
        $programaId = $programas[0];

        // Buscar las bodegas del programa
        $bodegas = $this->programasFarmaciaRepository->buscar($programaId)->bodegas;

        if (!$bodegas || $bodegas->isEmpty()) {
            return null;
        }

        // Buscar la primera bodega cuyo rep_id coincida con ipsAfiliado
        $bodega = $bodegas->first(fn($b) => $b->rep_id === $afiliado->ips_id);

        // Si no se encuentra, se direcciona con el programa BÁSICO
        return $bodega ? $bodega->rep_id : $this->direccionarProgramaUnicoBasico($afiliado);
    }

    /**
     * Direccionamiento para varios programas
     * @param array $programasIds
     * @param Afiliado $afiliado
     * @param int $consultaId
     * @return int|null
     * @author Thomas
     */
    private function direccionamientoVariosProgramas(array $programasIds, Afiliado $afiliado, int $consultaId): ?int
    {
        // Eliminar el programa BÁSICO del array (ID 1)
        $programasIds = array_filter($programasIds, fn($id) => $id !== 1);

        // Resetear los índices del array
        $programasIds = array_values($programasIds);

        // Si solo queda un programa, manejarlo con el direccionamiento de programa NO BÁSICO
        if (count($programasIds) === 1) {
            return $this->direccionarProgramaUnicoNOBasico($programasIds, $afiliado);
        }

        // Obtener la consulta y sus diagnósticos
        $consulta = $this->consultaRepository->buscar($consultaId);
        $diagnosticosConsulta = $consulta->cie10Afiliado->pluck('cie10_id')->toArray();

        if (!$diagnosticosConsulta || count($diagnosticosConsulta) < 1) {
            return $this->direccionarProgramaUnicoBasico($afiliado);
        }

        // Obtener los diagnósticos de cada programa
        $diagnosticosProgramas = [];
        foreach ($programasIds as $programaId) {
            $diagnosticosProgramas[$programaId] = $this->programasFarmaciaRepository->listarDiagnosticosPrograma($programaId);
        }

        // Verificar si la consulta es una transcripción
        if ($consulta->tipo_consulta_id == 1) {
            $programasCoincidentes = [];

            foreach ($diagnosticosProgramas as $programaId => $diagnosticosPrograma) {
                $coincidencias = array_intersect($diagnosticosConsulta, $diagnosticosPrograma->pluck('id')->toArray());
                if (!empty($coincidencias)) {
                    $programasCoincidentes[$programaId] = $coincidencias;
                }
            }

            // Si hay coincidencias, determinar cuál usar
            if (count($programasCoincidentes) === 1) {
                $programaSeleccionado = array_key_first($programasCoincidentes);
            } elseif (count($programasCoincidentes) > 1) {
                // Encontrar el diagnóstico más antiguo en la consulta
                $diagnosticoMasAntiguo = $diagnosticosConsulta
                    ->whereIn('codigo_cie10', array_merge(...array_values($programasCoincidentes)))
                    ->sortBy('created_at')
                    ->first();

                // Determinar a qué programa pertenece el diagnóstico más antiguo
                $programaSeleccionado = collect($programasCoincidentes)
                    ->filter(fn($diagnosticos) => in_array($diagnosticoMasAntiguo->codigo, $diagnosticos))
                    ->keys()
                    ->first();
            } else {
                $programaSeleccionado = null;
            }

            // Comparar los ids de las bodegas del programa con la ips del afiliado
            $bodegas = $this->programasFarmaciaRepository->buscar($programaSeleccionado)->bodegas;

            // Buscar la primera bodega cuyo rep_id coincida con ipsAfiliado
            $bodegaSeleccionada = $bodegas->first(fn($b) => $b->rep_id === $afiliado->ips_id);

            // Si no se encuentra, se direcciona con el programa BÁSICO
            return $bodegaSeleccionada ? $bodegaSeleccionada->rep_id : $this->direccionarProgramaUnicoBasico($afiliado);
        } else {

            // Cuando no es transcripción, usamos el diagnóstico primario de la consulta
            $diagnosticoPrimario = $consulta->cie10Afiliado->firstWhere('esprimario', true);

            if (!$diagnosticoPrimario) {
                return $this->direccionarProgramaUnicoBasico($afiliado);
            }

            // Comparar con los diagnósticos de los programas
            $programasCoincidentes = [];

            foreach ($diagnosticosProgramas as $programaId => $diagnosticosPrograma) {
                if ($diagnosticosPrograma->pluck('id')->contains($diagnosticoPrimario->cie10_id)) {
                    $programasCoincidentes[] = $programaId;
                }
            }

            // Un Cie10 solo puede pertenecer a un único programa, esta validación es por si acaso
            if (count($programasCoincidentes) > 1) {
                return $this->direccionarProgramaUnicoBasico($afiliado);
            }

            // Comparar los ids de las bodegas del programa con la ips del afiliado
            $bodegas = $this->programasFarmaciaRepository->buscar($programasCoincidentes[0])->bodegas;

            // Buscar la primera bodega cuyo rep_id coincida con ipsAfiliado
            $bodegaSeleccionada = $bodegas->first(fn($b) => $b->rep_id === $afiliado->ips_id);

            // Si no se encuentra, se direcciona con el programa BÁSICO
            return $bodegaSeleccionada ? $bodegaSeleccionada->rep_id : $this->direccionarProgramaUnicoBasico($afiliado);
        }
    }

    /**
     * Guardar nota adicional
     * @param array $data
     * @return bool
     * @author Thomas
     */
    public function agregarNotaAdicionalOrdenServicios(array $data): bool
    {
        $userId = Auth::id();
        $ordenProcedimientos = $data['orden_procedimientos'];
        $observacion = $data['observacion'];
        $createdAt = now();
        $updatedAt = now();

        // Obtener los registros
        $ordenes = OrdenProcedimiento::whereIn('id', $ordenProcedimientos)->get(['id']);

        // Guardar el histórico de los cambios
        $cambios = $ordenes->map(function ($orden) use ($userId, $observacion, $createdAt, $updatedAt) {
            return [
                'orden_procedimiento_id' => $orden->id,
                'observacion' => $observacion,
                'accion' => 'Creación de nota adicional',
                'user_id' => $userId,
                'created_at' => $createdAt,
                'updated_at' => $updatedAt
            ];
        })->toArray();

        return CambiosOrdene::insert($cambios);
    }

    public function cambiarDireccionamientoServicios(array $data): bool
    {
        $userId = Auth::id();
        $ordenProcedimientos = $data['orden_procedimientos'];
        $nuevoRepId = $data['rep_id'];
        $createdAt = now();
        $updatedAt = now();

        // Obtener los registros actuales antes de la actualización
        $ordenes = OrdenProcedimiento::whereIn('id', $ordenProcedimientos)->get(['id', 'rep_id']);

        DB::transaction(function () use ($ordenProcedimientos, $nuevoRepId, $userId, $ordenes, $createdAt, $updatedAt) {
            // Actualizar los registros en una sola consulta
            OrdenProcedimiento::whereIn('id', $ordenProcedimientos)->update(['rep_id' => $nuevoRepId]);

            // Guardar el histórico de los cambios
            $cambios = $ordenes->map(function ($orden) use ($userId, $nuevoRepId, $createdAt, $updatedAt) {
                return [
                    'orden_procedimiento_id' => $orden->id,
                    'observacion' => 'Cambio de Direccionamiento de Servicios',
                    'accion' => 'Actualización de prestador',
                    'user_id' => $userId,
                    'rep_anterior_id' => $orden->rep_id,
                    'rep_nuevo_id' => $nuevoRepId,
                    'created_at' => $createdAt,
                    'updated_at' => $updatedAt
                ];
            })->toArray();

            CambiosOrdene::insert($cambios);
        });

        return true;
    }

    /**
     * Agrega nuevos servicios a una orden
     * @param array $data
     * @return array
     * @throws Exception
     * @author Thomas
     */
    public function agregarNuevosServicios(array $data): array
    {
        $ordenId = $data['orden_id'];
        $timestamps = now();

        // Cargar la orden con sus procedimientos para evitar consultas adicionales
        $orden = Orden::with('procedimientos')->findOrFail($ordenId);
        $nuevosServicios = collect($data['servicios']);

        // Obtener los IDs de los servicios ya ordenados en esta orden
        $serviciosActualesIds = array_flip($orden->procedimientos->pluck('cup_id')->toArray());

        // Obtener los datos de los cups involucrados en la solicitud en un mapa para acceso rápido
        $cupsInfo = Cup::whereIn('id', $nuevosServicios->pluck('cup_id')->toArray())
            ->select('id', 'codigo', 'nombre', 'cantidad_max_ordenamiento')
            ->get()
            ->keyBy('id');

        // Validar que los servicios NO estén ya en la orden
        $nuevosDuplicados = $nuevosServicios->filter(fn($servicio) => isset($serviciosActualesIds[$servicio['cup_id']]))
            ->map(fn($servicio) => [
                'cup_id' => $servicio['cup_id'],
                'codigo' => $cupsInfo[$servicio['cup_id']]->codigo ?? 'Desconocido',
                'nombre' => $cupsInfo[$servicio['cup_id']]->nombre ?? 'Desconocido',
            ]);

        if ($nuevosDuplicados->isNotEmpty()) {
            throw new \Exception(json_encode([
                'error' => 'Los siguientes servicios ya se encuentran ordenados.',
                'servicios_duplicados' => $nuevosDuplicados->values()->all(),
                'tipo_error' => 'servicios_duplicados'
            ]), 409);
        }

        // Validar cantidad máxima permitida
        $nuevosExcedidos = $nuevosServicios->filter(
            fn($servicio) => isset($cupsInfo[$servicio['cup_id']]) &&
            $servicio['cantidad'] > $cupsInfo[$servicio['cup_id']]->cantidad_max_ordenamiento
        )->map(fn($servicio) => [
                'cup_id' => $servicio['cup_id'],
                'codigo' => $cupsInfo[$servicio['cup_id']]->codigo ?? 'Desconocido',
                'nombre' => $cupsInfo[$servicio['cup_id']]->nombre ?? 'Desconocido',
                'cantidad_maxima' => $cupsInfo[$servicio['cup_id']]->cantidad_max_ordenamiento,
                'cantidad_intentada' => $servicio['cantidad']
            ]);

        if ($nuevosExcedidos->isNotEmpty()) {
            throw new \Exception(json_encode([
                'error' => 'Algunos servicios exceden la cantidad máxima permitida.',
                'servicios_excedidos' => $nuevosExcedidos->values()->all(),
                'tipo_error' => 'cantidad_excedida'
            ]), 409);
        }

        // Preparar datos para inserción masiva
        $datosInsertar = $nuevosServicios->map(fn($servicio) => [
            'orden_id' => $ordenId,
            'cup_id' => $servicio['cup_id'],
            'rep_id' => null,
            'estado_id' => 3,
            'cantidad' => $servicio['cantidad'],
            'fecha_vigencia' => $servicio['fecha_vigencia'],
            'observacion' => $servicio['observacion'],
            'autorizacion' => false,
            'estado_id_gestion_prestador' => 50,
            'created_at' => $timestamps,
            'updated_at' => $timestamps
        ])->toArray();

        // Insertar en la base de datos
        OrdenProcedimiento::insert($datosInsertar);

        return [
            'mensaje' => 'Servicios agregados exitosamente.',
            'servicios_agregados' => count($datosInsertar)
        ];
    }

    public function agregarNuevosCodigosPropios(array $data)
    {
        $ordenId = $data['orden_id'];
        $timestamps = now();

        // Cargar la orden con sus códigos propios para evitar consultas adicionales
        $orden = Orden::with('ordenesCodigoPropio')->findOrFail($ordenId);
        $nuevosCodigosPropios = collect($data['codigos_propios']);

        // Obtener los IDs de los servicios ya ordenados en esta orden
        $codigosPropiosActualesIds = array_flip($orden->ordenesCodigoPropio->pluck('codigo_propio_id')->toArray());

        // Obtener los datos de los cups involucrados en la solicitud en un mapa para acceso rápido
        $codigosPropiosInfo = CodigoPropio::whereIn('id', $nuevosCodigosPropios->pluck('codigo_propio_id')->toArray())
            ->select('id', 'codigo', 'nombre', 'cantidad_max_ordenamiento')
            ->get()
            ->keyBy('id');

        // Validar que los códigos propios NO estén ya en la orden
        $nuevosDuplicados = $nuevosCodigosPropios->filter(fn($codigoPropio) => isset($codigosPropiosActualesIds[$codigoPropio['codigo_propio_id']]))
            ->map(fn($codigoPropio) => [
                'codigo_propio_id' => $codigoPropio['codigo_propio_id'],
                'codigo' => $codigosPropiosInfo[$codigoPropio['codigo_propio_id']]->codigo ?? 'Desconocido',
                'nombre' => $codigosPropiosInfo[$codigoPropio['codigo_propio_id']]->nombre ?? 'Desconocido',
            ]);

        if ($nuevosDuplicados->isNotEmpty()) {
            throw new \Exception(json_encode([
                'error' => 'Los siguientes servicios ya se encuentran ordenados.',
                'servicios_duplicados' => $nuevosDuplicados->values()->all(),
                'tipo_error' => 'servicios_duplicados'
            ]), 409);
        }

        // Validar cantidad máxima permitida
        $nuevosExcedidos = $nuevosCodigosPropios->filter(
            fn($codigoPropio) => isset($codigosPropiosInfo[$codigoPropio['codigo_propio_id']]) &&
            $codigoPropio['cantidad'] > $codigosPropiosInfo[$codigoPropio['codigo_propio_id']]->cantidad_max_ordenamiento
        )->map(fn($codigoPropio) => [
                'codigo_propio_id' => $codigoPropio['codigo_propio_id'],
                'codigo' => $codigosPropiosInfo[$codigoPropio['codigo_propio_id']]->codigo ?? 'Desconocido',
                'nombre' => $codigosPropiosInfo[$codigoPropio['codigo_propio_id']]->nombre ?? 'Desconocido',
                'cantidad_maxima' => $codigosPropiosInfo[$codigoPropio['codigo_propio_id']]->cantidad_max_ordenamiento,
                'cantidad_intentada' => $codigoPropio['cantidad']
            ]);

        if ($nuevosExcedidos->isNotEmpty()) {
            throw new \Exception(json_encode([
                'error' => 'Algunos servicios exceden la cantidad máxima permitida.',
                'servicios_excedidos' => $nuevosExcedidos->values()->all(),
                'tipo_error' => 'cantidad_excedida'
            ]), 409);
        }

        // Preparar datos para inserción masiva
        $datosInsertar = $nuevosCodigosPropios->map(fn($codigoPropio) => [
            'orden_id' => $ordenId,
            'codigo_propio_id' => $codigoPropio['codigo_propio_id'],
            'rep_id' => null,
            'estado_id' => 3,
            'cantidad' => $codigoPropio['cantidad'],
            'fecha_vigencia' => $codigoPropio['fecha_vigencia'],
            'observacion' => $codigoPropio['observacion'],
            'autorizacion' => false,
            'estado_id_gestion_prestador' => 50,
            'created_at' => $timestamps,
            'updated_at' => $timestamps
        ])->toArray();

        // Insertar en la base de datos
        OrdenCodigoPropio::insert($datosInsertar);

        return [
            'mensaje' => 'Servicios agregados exitosamente.',
            'servicios_agregados' => count($datosInsertar)
        ];
    }

    /**
     * Cambiar el direccionamiento de una orden de códigos propios
     * @param array $data
     * @return bool
     * @throws \Throwable
     * @author Thomas
     */
    public function cambiarDireccionamientoCodigosPropios(array $data): bool
    {
        $userId = Auth::id();
        $ordenCodigosPropios = $data['orden_codigos_propios'];
        $nuevoRepId = $data['rep_id'];
        $createdAt = now();
        $updatedAt = now();

        // Obtener los registros actuales antes de la actualización
        $ordenes = OrdenCodigoPropio::whereIn('id', $ordenCodigosPropios)->get(['id', 'rep_id']);

        DB::transaction(function () use ($ordenCodigosPropios, $nuevoRepId, $userId, $ordenes, $createdAt, $updatedAt) {
            // Actualizar los registros en una sola consulta
            OrdenCodigoPropio::whereIn('id', $ordenCodigosPropios)->update(['rep_id' => $nuevoRepId]);

            // Guardar el histórico de los cambios
            $cambios = $ordenes->map(function ($orden) use ($userId, $nuevoRepId, $createdAt, $updatedAt) {
                return [
                    'orden_codigo_propio_id' => $orden->id,
                    'observacion' => 'Cambio de Direccionamiento de Códigos Propios',
                    'accion' => 'Actualización de prestador',
                    'user_id' => $userId,
                    'rep_anterior_id' => $orden->rep_id,
                    'rep_nuevo_id' => $nuevoRepId,
                    'created_at' => $createdAt,
                    'updated_at' => $updatedAt
                ];
            })->toArray();

            CambiosOrdene::insert($cambios);
        });

        return true;
    }

    /**
     * Agregar una nota adicional a una orden de códigos propios
     * @param array $data
     * @return bool
     * @author Thomas
     */
    public function agregarNotaAdicionalOrdenCodigosPropios(array $data): bool
    {
        $userId = Auth::id();
        $ordenCodigosPropios = $data['orden_codigos_propios'];
        $observacion = $data['observacion'];
        $createdAt = now();
        $updatedAt = now();

        // Obtener los registros
        $ordenes = OrdenCodigoPropio::whereIn('id', $ordenCodigosPropios)->get(['id']);

        // Guardar el histórico de los cambios
        $cambios = $ordenes->map(function ($orden) use ($userId, $observacion, $createdAt, $updatedAt) {
            return [
                'orden_codigo_propio_id' => $orden->id,
                'observacion' => $observacion,
                'accion' => 'Creación de nota adicional',
                'user_id' => $userId,
                'created_at' => $createdAt,
                'updated_at' => $updatedAt
            ];
        })->toArray();

        return CambiosOrdene::insert($cambios);
    }

    /**
     * Cambiar direccionamiento de medicamentos
     * @param array $data
     * @return void
     * @author Thomas
     */
    public function cambiarDireccionamientoMedicamentos(array $data): void
    {
        DB::transaction(function () use ($data) {
            $userId = Auth::id();
            $ordenArticulos = $data['orden_articulos'];
            $nuevoRepId = $data['rep_id'];
            $createdAt = now();
            $updatedAt = now();

            // Obtener los registros actuales antes de la actualización
            $ordenes = OrdenArticulo::whereIn('id', $ordenArticulos)->get(['id', 'rep_id']);

            // Actualizar los registros en una sola consulta
            OrdenArticulo::whereIn('id', $ordenArticulos)->update(['rep_id' => $nuevoRepId]);

            // Guardar el histórico de los cambios
            $cambios = $ordenes->map(function ($orden) use ($userId, $nuevoRepId, $createdAt, $updatedAt) {
                return [
                    'orden_articulo_id' => $orden->id,
                    'observacion' => 'Cambio de Direccionamiento de Medicamentos',
                    'accion' => 'Actualización de prestador',
                    'user_id' => $userId,
                    'rep_anterior_id' => $orden->rep_id,
                    'rep_nuevo_id' => $nuevoRepId,
                    'created_at' => $createdAt,
                    'updated_at' => $updatedAt
                ];
            })->toArray();

            return CambiosOrdene::insert($cambios);
        });
    }

    public function registrarCobro($afiliado_id, $request)
    {

        $factura = CobroFacturas::create([
            'afiliado_id' => $afiliado_id,
            'medio_pago' => $request['medio_pago'],
            'user_cobro_id' => auth()->id(),
            'valor' => $request['valor'],
        ]);

        foreach ($request['servicios'] as $servicio) {
            CobroServicio::where('orden_procedimiento_id', $servicio)
                ->where('estado_id', 1)
                ->update([
                    'estado_id' => 14,
                    'fecha_cobro' => date('Y-m-d'),
                    'medio_pago' => $request['medio_pago'],
                    'usuario_cobra' => auth()->id(),
                    'cobro_factura_id' => $factura->id,
                ]);
        }

        return $factura;
    }

    /**
     * Cambia el servicio de una orden existente.
     * @param int $ordenId
     * @param array $data
     * @return array
     * @throws \Throwable
     * @throws Exception
     * @author Thomas
     */

    public function cambiarServicioOrden(int $ordenId, array $data): array
    {
        return DB::transaction(function () use ($ordenId, $data) {
            $userId = Auth::id();

            // Validar que no exista un OrdenProcedimiento con el mismo CUP
            $cupExistente = $this->ordenProcedimientoRepository->validarExistenciaCupOrden($ordenId, $data['cup_id']);

            if ($cupExistente !== null) {
                throw new Exception('Ya existe un Servicio con el mismo CUP en esta orden.', 409);
            }

            // Validar que la cantidad no supere la permitida
            $cup = $this->cupRepository->buscar($data['cup_id']);

            $cantidadSolicitada = $data['cantidad'];
            $maximoPermitido = $cup->cantidad_max_ordenamiento;

            if (!is_null($maximoPermitido) && $cantidadSolicitada > $maximoPermitido) {
                throw new Exception("La cantidad solicitada ($cantidadSolicitada) supera el máximo permitido ($maximoPermitido) para este servicio.", 422);
            }

            // Cambiar el Servicio
            $ordenProcedimiento = $this->ordenProcedimientoRepository->buscar($data['orden_procedimiento_id']);

            // Obtener los valores anteriores para la auditoría
            $cupAnterior = $ordenProcedimiento->cup?->codigo ?? 'N/A';
            $nombreAnterior = $ordenProcedimiento->cup?->nombre ?? 'N/A';
            $cantidadAnterior = $ordenProcedimiento->cantidad;
            $observacionAnterior = $ordenProcedimiento->observacion;

            // Actualizar el procedimiento
            $this->ordenProcedimientoRepository->actualizar($ordenProcedimiento, [
                'cup_id' => $data['cup_id'],
                'cantidad' => $data['cantidad'],
                'observacion' => $data['observacion'] ?? null,
            ]);

            // Guardar auditoría
            $this->cambiosOrdenesRepository->crear([
                'user_id' => $userId,
                'orden_procedimiento_id' => $ordenProcedimiento->id,
                'accion' => 'Cambio de Servicio',
                'observacion' => "Se cambió el CUP {$cupAnterior} ({$nombreAnterior}), cantidad anterior: {$cantidadAnterior}, observación anterior: {$observacionAnterior}",
            ]);

            return [
                'mensaje' => 'Servicio actualizado correctamente.',
                'orden_procedimiento' => $ordenProcedimiento->fresh('cup'),
            ];
        });
    }

    /**
     * Cambia el código propio de una orden existente.
     * @param int $ordenId
     * @param array $data
     * @return array
     * @throws \Throwable
     * @throws Exception
     * @author Thomas
     */
    public function cambiarCodigoPropioOrden(int $ordenId, array $data): array
    {
        return DB::transaction(function () use ($ordenId, $data) {
            $userId = Auth::id();

            // Validar que no exista un OrdenCodigoPropio con el mismo Código Propio
            $codigoPropioExistente = $this->ordenCodigoPropioRepository->findByCodigoAndOrden($ordenId, $data['codigo_propio_id']);

            if ($codigoPropioExistente !== null) {
                throw new Exception('Ya existe un Servicio con el mismo Código Propio en esta orden.', 409);
            }

            // Validar que la cantidad no supere la permitida
            $codigoPropio = $this->codigoPropioRepository->buscar($data['codigo_propio_id']);

            $cantidadSolicitada = $data['cantidad'];
            $maximoPermitido = $codigoPropio->cantidad_max_ordenamiento;

            if (!is_null($maximoPermitido) && $cantidadSolicitada > $maximoPermitido) {
                throw new Exception("La cantidad solicitada ($cantidadSolicitada) supera el máximo permitido ($maximoPermitido) para este servicio.", 422);
            }

            // Cambiar el Código Propio
            $ordenCodigoPropio = $this->ordenCodigoPropioRepository->buscar($data['orden_codigo_propio_id']);

            // Obtener los valores anteriores para la auditoría
            $codigoPropioAnterior = $ordenCodigoPropio->codigoPropio?->codigo ?? 'N/A';
            $nombreAnterior = $ordenCodigoPropio->codigoPropio?->nombre ?? 'N/A';
            $cantidadAnterior = $ordenCodigoPropio->cantidad;
            $observacionAnterior = $ordenCodigoPropio->observacion;

            // Actualizar el procedimiento
            $this->ordenCodigoPropioRepository->actualizar($ordenCodigoPropio, [
                'codigo_propio_id' => $data['codigo_propio_id'],
                'cantidad' => $data['cantidad'],
                'observacion' => $data['observacion'] ?? null,
            ]);

            // Guardar auditoría
            $this->cambiosOrdenesRepository->crear([
                'user_id' => $userId,
                'orden_codigo_propio_id' => $ordenCodigoPropio->id,
                'accion' => 'Cambio de Código Propio',
                'observacion' => "Se cambió el Código Propio {$codigoPropioAnterior} ({$nombreAnterior}), cantidad anterior: {$cantidadAnterior}, observación anterior: {$observacionAnterior}",
            ]);

            return [
                'mensaje' => 'Código Propio actualizado correctamente.',
                'orden_codigo_propio' => $ordenCodigoPropio->fresh('codigoPropio'),
            ];
        });
    }


    /**
     * Actualiza las ordenes de procedimientos recibidas (id's) con la informacion del consentimiento informado enviada
     * @param array $data_procedimientos
     * @throws \Exception
     * @return bool
     * @author AlejoSR
     */
    public function firmarConsentimientosOrdenes(array $data_procedimientos)
    {
        try {
            $fechaFirma = Carbon::now();
            $firmaProfesional = auth()->user()->firma;

            #para cada id de la orden procedimiento que llegue, se realiza la actualizacion de los datos de consentimiento informado
            foreach ($data_procedimientos['id'] as $procedimiento) {

                #consulto la orden por su id
                $orden = $this->ordenProcedimientoRepository->obtenerOrdenProcedimiento($procedimiento);
                if (!$orden) {
                    throw new Exception('El procedimiento con id ' . $procedimiento . ' no se encuentra registrado');
                }

                #se actualiza cada orden con la informacion que llegue
                $orden->update([
                    'firma_consentimiento' => $data_procedimientos['firma_paciente'],
                    'fecha_firma' => !$data_procedimientos['firma_disentimiento'] ? $fechaFirma : null,
                    'firmante' => $data_procedimientos['firmante'],
                    'numero_documento_representante' => $data_procedimientos['numero_documento_representante'],
                    'declaracion_a' => $data_procedimientos['declaracion_a'],
                    'declaracion_b' => $data_procedimientos['declaracion_b'],
                    'declaracion_c' => $data_procedimientos['declaracion_c'],
                    'nombre_profesional' => $data_procedimientos['nombre_profesional'],
                    'nombre_representante' => $data_procedimientos['nombre_representante'],
                    'firma_discentimiento' => $data_procedimientos['firma_disentimiento'],
                    'fecha_firma_discentimiento' => $data_procedimientos['firma_disentimiento'] ? $fechaFirma : null,
                    'aceptacion_consentimiento' => $data_procedimientos['aceptacion_consentimiento'],
                    'firma_representante' => $data_procedimientos['firma_representante'],
                    'firma_profesional' => $firmaProfesional,
                    'embarazo' => $data_procedimientos['embarazo'] ?? null,
                ]);
            }
            return true;
        } catch (\Throwable $th) {
            throw $th;
        }
    }

    /**
     * Firma los consentimientos diferentes a laboratorios, asociados a una orden
     * @param array $data_consentimiento
     * @return bool
     */
    public function firmarConsentimientosOrden(array $data_consentimiento)
    {
        try {


            #obtenemos todas las ordenes que tengan un consentimiento informado asociado al cup del procedimiento que no sea laboratorio
            $ordenesProcedimientos = $this->ordenProcedimientoRepository
                ->obtenerProcedimientosOrden($data_consentimiento['orden_id'])
                ->load(['cup', 'cup.consentimientoInformado'])
                ->filter(fn($orden) => !is_null($orden->cup->consentimientoInformado) && $orden->cup->consentimientoInformado->laboratorio == false);


            #verificamos si vienen dientes, lo que significa que es consentimiento de odontologia, por lo tanto verificamos cual cups y orden procedimiento está asociado a consentimiento de odontologia para asociarlo en la tabla de dientes
            if (isset($data_consentimiento['dientes']) && count($data_consentimiento['dientes']) > 0) {

                #se extrae el numero del orden procedimiento en la cual el cup asociado requiere consentimiento y es odontologico
                $ordenProcedimiento = $ordenesProcedimientos->filter(function ($orden) {
                    return $orden->cup->consentimientoInformado && $orden->cup->consentimientoInformado->odontologia == true;
                })->pluck('id');


                #Para cada numero de orden procedimiento se le asocian los dientes que llegan en la tabla dientes
                foreach ($ordenProcedimiento as $orden) {
                    foreach ($data_consentimiento['dientes'] as $diente) {
                        $this->dientesOrdenProcedimientos->firstOrCreate([
                            'diente' => $diente['diente'],
                            'fecha' => $diente['fecha'],
                            'orden_procedimiento_id' => $orden
                        ]);
                    }
                }
            }

            #continuamos el resto del proceso de firma de los procedimientos. Agregamos el campo id a la data del consentimiento firmado
            $ordenesProcedimientos = $ordenesProcedimientos->pluck('id');
            $data_consentimiento['id'] = $ordenesProcedimientos;

            #firmamos los consentimientos de los procedimientos que se obtuvieron, usando la funcion ya creada
            $firma = $this->firmarConsentimientosOrdenes($data_consentimiento);

            return $firma;
        } catch (\Throwable $th) {
            throw $th;
        }
    }

    public function firmar(array $data_procedimientos)
    {
        $fechaFirma = Carbon::now();

        try {
            foreach ($data_procedimientos['orden_procedimiento'] as $procedimiento) {
                $orden = $this->ordenProcedimientoRepository->obtenerOrdenProcedimiento($procedimiento);

                if (!$orden) {
                    throw new Exception('El procedimiento con id ' . $procedimiento . ' no se encuentra registrado');
                }

                $orden->update([
                    'firma_paciente' => $data_procedimientos['firma_paciente'],
                    'fecha_firma' => $fechaFirma
                ]);
            }
            return true;
        } catch (\Throwable $th) {
            throw $th;
        }
    }
    /**
     * Genera una orden y sus articulos intrahospitalarios
     * @param array $data
     * @return Orden
     * @author Thomas
     */
    public function generarOrdenamientoIntrahospitalario(array $data): Orden
    {


        return DB::transaction(function () use ($data) {
            $user = Auth::user();
            $timestamp = Carbon::now();

            // Crear la Orden
            $datosOrden = [
                'tipo_orden_id' => 5,
                'consulta_id' => $data['consulta_id'],
                'user_id' => $user->id,
                'estado_id' => 1,
                'paginacion' => '1/1',
                'fecha_vigencia' => $timestamp
            ];

            $orden = $this->ordenRepository->crear($datosOrden);

            // Crear los registros de los articulos
            $datosOrdenArticulos = collect($data['articulos'])->map(function ($articulo) use ($orden, $user, $timestamp) {
                return [
                    'orden_id' => $orden->id,
                    'codesumi_id' => $articulo['codesumi_id'],
                    'estado_id' => 1,
                    'via_administracion_id' => $articulo['via_administracion_id'],
                    'finalizacion' => $articulo['finalizacion'],
                    'dosis' => $articulo['dosis'],
                    'frecuencia' => $articulo['frecuencia'] ?? null,
                    'unidad_tiempo' => $articulo['unidad_tiempo'] ?? null,
                    'horas_vigencia' => $articulo['horas_vigencia'],
                    'cantidad' => $articulo['cantidad'],
                    'observacion' => $articulo['observacion'],
                    'user_crea_id' => $user->id,
                    'created_at' => $timestamp,
                    'updated_at' => $timestamp,
                ];
            })->toArray();

            $this->ordenArticuloIntrahospitalarioRepository->insertarMasivo($datosOrdenArticulos);

            return $orden;
        });
    }

    /**
     * envia una notificacion de dispensacion, traduce a una notificacion de despacho
     */
    public function notificarOrdenDispensada(Movimiento|int $movimiento)
    {
        if (is_int($movimiento)) {
            $movimiento = Movimiento::findOrFail($movimiento);
        }

        $movimiento->loadMissing(
            'orden',
            'ordenArticulo.codesumi.formaFarmaceutica',
            'bodegaOrigen.municipio.departamento',
        );

        $json = [
            'orden' => [
                'Orden_id' => $movimiento->orden->id,
                'Orden_dispensacion_id' => $movimiento->orden->id,
                'Estado_Entrega' => 1,
            ],
            'medicamento' => [
                'Cums' => $movimiento->ordenArticulo->codesumi->codigo,
                'Nombre_Medicamento' => $movimiento->ordenArticulo->codesumi->nombre,
                'Concentracion' => $movimiento->ordenArticulo->codesumi->unidad_concentracion,
                'Forma_Farmaceutica' => $movimiento->ordenArticulo->codesumi->formaFarmaceutica->nombre,
                'Via_Administracion' => $movimiento->ordenArticulo->codesumi->via,
                'Medicamento_PBS' => $movimiento->ordenArticulo->codesumi->estado_normativo === 'PBS' ? true : false,
            ],
            'dispensacion' => [
                'Fecha_Entrega' => (string) $movimiento->created_at,
                'Cantidad_Prescrita' => (string) $movimiento->ordenArticulo->cantidad_medico,
                'Cantidad_Entregada' => (string) $movimiento->ordenArticulo->cantidad_entregada,
                'Cantidad_Pendiente' => (string) ($movimiento->ordenArticulo->cantidad_medico - $movimiento->ordenArticulo->cantidad_entregada),
                'Entrega_Domicilio' => $movimiento->ordenArticulo->domicilio,
                'Asegurador' => 'sin asegurador',
            ],
            'farmacia' => [
                'Codigo' => (string) $movimiento->bodegaOrigen->id,
                'Nombre_Farmacia' => $movimiento->bodegaOrigen->nombre,
                'Direccion_Farmacia' => $movimiento->bodegaOrigen->direccion,
                'Ciudad_Farmacia' => $movimiento->bodegaOrigen->municipio->nombre,
                'Departamento_Farmacia' => $movimiento->bodegaOrigen->municipio->departamento->nombre,
            ],
        ];

        $response = $this->fomagHttp->enviarNotificacionDespacho($json);

        if ($response->failed()) {
            Storage::append('fomag.log', json_encode($response->json()));
            throw new Exception('Error al enviar la notificación de despacho a FOMAG', 400);
        }

        return $response->json();
    }

    public function listarServiciosPendientesFacturar($afiliadoId)
    {
        $afiliado = Afiliado::where('id', $afiliadoId)->first();
        $tipoDocumento = $afiliado->tipoDocumento->sigla;
        $numDocumento = $afiliado->numero_documento;
        $codDepartamento = $afiliado->departamento_afiliacion->codigo_dane;
        $codMunicipio = $afiliado->municipio_afiliacion->codigo_dane;
        // $nombreCompleto = trim($afiliado->primer_nombre . ' ' . ($afiliado->segundo_nombre ? $afiliado->segundo_nombre . ' ' : '') . $afiliado->primer_apellido . ' ' . ($afiliado->segundo_apellido ?? ''));
        $contrato = $afiliado->entidad_id = 1 ? '7239' : '7310'; // Asumiendo que 1 es el contrato de SISMA y 2 es otro contrato
        $afiliadoSisma = $this->sismaService->verificarPaciente($tipoDocumento, $numDocumento);
        if ($afiliadoSisma['autoId'] == null) {
            $nuevoPaciente = $this->sismaService->crearPaciente([
                "tipoId" => $tipoDocumento,
                "numId" => $numDocumento,
                "primerApellido" => $afiliado->primer_apellido,
                "segundoApellido" => $afiliado->segundo_apellido ?? '',
                "primerNombre" => $afiliado->primer_nombre,
                "segundoNombre" => $afiliado->segundo_nombre ?? '',
                "direccion" => $afiliado->direccion_residencia_cargue,
                "fechaNacimiento" => $afiliado->fecha_nacimiento,
                "sexo" => $afiliado->sexo,
                "contrato" => $contrato,
                "email" => $afiliado->correo1,
                "codDepartamento" => $codDepartamento,
                "codMunicipio" => $codMunicipio,
                "barrio" => "4141",
                "regimenJson" => 1,
                "codUsuario" => "000000",
                "nomUsuario" => "Procesos Automaticos",
                "usuario" => 2706
            ]);

            $afiliadoInteroperabilidadSisma = $nuevoPaciente['id'];
        } else {
            $afiliadoInteroperabilidadSisma = $afiliadoSisma['autoId'];
        }
        // dd($afiliadoInteroperabilidadSisma);

        $servicios = $this->sismaService->listarServiciosPendientesFacturar($numDocumento);

        dd('piti', $servicios['base64']);
    }

    public function validarOrdenYCita(array $data)
    {
        if (!$this->citaTieneSede($data['cita_id'], $data['rep_id'])) {
            return collect();
        }

        $cupsCita = $this->obtenerCupsDeCita($data['cita_id']);

        if ($cupsCita->isEmpty()) {
            return collect();
        }

        $repIdsAsociados = $this->obtenerRepsDeCita($data['cita_id']);

        $ordenesProcedimientos = collect($this->obtenerOrdenesProcedimientos($data['afiliado_id'], $repIdsAsociados, $cupsCita));
        $ordenesCodigoPropios = collect($this->obtenerOrdenesCodigoPropios($data['afiliado_id'], $repIdsAsociados, $cupsCita));

        return $ordenesProcedimientos->merge($ordenesCodigoPropios);
    }

    private function obtenerRepsDeCita($citaId)
    {
        return DB::table('cita_reps')
            ->where('cita_id', $citaId)
            ->pluck('rep_id');
    }

    /**
     * Verifica si una cita tiene asociada una sede.
     *
     * @param int $citaId
     * @param int $repId
     * @return bool
     */
    private function citaTieneSede($citaId, $repId)
    {
        return DB::table('cita_reps')
            ->where('cita_id', $citaId)
            ->where('rep_id', $repId)
            ->exists();
    }

    /**
     * Obtiene los id de los cups asociados a una cita.
     *
     * @param int $citaId
     */
    private function obtenerCupsDeCita($citaId)
    {
        return DB::table('cita_cup')
            ->where('cita_id', $citaId)
            ->pluck('cup_id');
    }

    /**
     * Obtiene los procedimientos ordenados para un afiliado, que coincidan con los cups
     * de la cita y que estén en estado válido.
     *
     * @param int $afiliadoId
     * @param int $repId
     */
    private function obtenerOrdenesProcedimientos($afiliadoId, $repIds, $cups)
    {
        return OrdenProcedimiento::select(
            'orden_procedimientos.id as servicio_id',
            'orden_procedimientos.orden_id',
            'orden_procedimientos.cup_id',
            'orden_procedimientos.observacion as observaciones',
            'orden_procedimientos.estado_id',
            'orden_procedimientos.rep_id',
            'orden_procedimientos.cantidad',
            'orden_procedimientos.cantidad_usada',
            'orden_procedimientos.cantidad_pendiente',
            'afiliados.primer_nombre',
            'afiliados.segundo_nombre',
            'afiliados.primer_apellido',
            'afiliados.segundo_apellido',
            'cups.nombre as servicio',
            'cups.codigo as codigoServicio',
            'cs.estado_id as estado_cobro',
            'cs.tipo as tipo_cobro',
            'cs.valor',
            DB::raw("'procedimiento' as tipo")
        )
            ->join('ordenes', 'orden_procedimientos.orden_id', 'ordenes.id')
            ->join('consultas', 'ordenes.consulta_id', 'consultas.id')
            ->join('afiliados', 'consultas.afiliado_id', 'afiliados.id')
            ->join('cups', 'orden_procedimientos.cup_id', 'cups.id')
            ->leftjoin('cobro_servicios as cs', 'orden_procedimientos.id', 'cs.orden_procedimiento_id')
            ->where('consultas.afiliado_id', $afiliadoId)
            ->whereIn('orden_procedimientos.rep_id', $repIds)
            ->whereIn('orden_procedimientos.estado_id', [1, 4])
            ->whereIn('orden_procedimientos.cup_id', $cups)
            ->where(function ($query) {
                //Incluir órdenes con cobros de tipo copago o cuota que estén en estado 14
                $query->where(function ($q) {
                    $q->where('cs.estado_id', 1)
                        ->whereIn('cs.tipo', ['copago', 'cuota', 'Exento']);
                })
                    //O incluir órdenes que no tienen cobro registrado
                    ->orWhereNull('cs.id');
            })
            ->get();
    }

    private function obtenerOrdenesCodigoPropios($afiliadoId, $repIds, $cups)
    {
        $codigoPropiosRelacionados = DB::table('codigo_propios')
            ->whereIn('cup_id', $cups)
            ->pluck('id');
        return OrdenCodigoPropio::select(
            'orden_codigo_propios.id as servicio_id',
            'orden_codigo_propios.orden_id',
            'orden_codigo_propios.codigo_propio_id',
            'orden_codigo_propios.observacion as observaciones',
            'orden_codigo_propios.estado_id',
            'orden_codigo_propios.rep_id',
            'orden_codigo_propios.cantidad',
            'orden_codigo_propios.cantidad_usada',
            'orden_codigo_propios.cantidad_pendiente',
            'afiliados.primer_nombre',
            'afiliados.segundo_nombre',
            'afiliados.primer_apellido',
            'afiliados.segundo_apellido',
            'codigo_propios.nombre as servicio',
            'codigo_propios.codigo as codigoServicio',
            'cs.estado_id as estado_cobro',
            'cs.tipo as tipo_cobro',
            'cs.valor',
            DB::raw("'codigo_propio' as tipo")
        )
            ->join('ordenes', 'orden_codigo_propios.orden_id', 'ordenes.id')
            ->join('consultas', 'ordenes.consulta_id', 'consultas.id')
            ->join('afiliados', 'consultas.afiliado_id', 'afiliados.id')
            ->join('codigo_propios', 'orden_codigo_propios.codigo_propio_id', 'codigo_propios.id')
            ->leftjoin('cobro_servicios as cs', 'orden_codigo_propios.id', 'cs.orden_codigo_propio_id')
            ->where('consultas.afiliado_id', $afiliadoId)
            ->whereIn('orden_codigo_propios.rep_id', $repIds)
            ->whereIn('orden_codigo_propios.estado_id', [1, 4])
            ->whereIn('orden_codigo_propios.codigo_propio_id', $codigoPropiosRelacionados)
            ->where(function ($query) {
                //Incluir órdenes con cobros de tipo copago o cuota que estén en estado 14
                $query->where(function ($q) {
                    $q->where('cs.estado_id', 1)
                        ->whereIn('cs.tipo', ['copago', 'cuota', 'Exento']);
                })
                    //O incluir órdenes que no tienen cobro registrado
                    ->orWhereNull('cs.id');
            })
            ->get();
    }

    public function listarOrdenesPorCobrar(int $consulta_id)
    {
        $hoy = now();
        $cambio = now()->subDays(180);
        $estados = [1, 4, 3];

        [$laboratorios, $idsLab] = $this->cobroServicioRepository->obtenerOrdenesAgrupadas($consulta_id, 45, $cambio, $hoy, $estados);
        [$ayudasDX, $idsDx] = $this->cobroServicioRepository->obtenerOrdenesAgrupadas($consulta_id, 46, $cambio, $hoy, $estados);

        $ordenesAgrupadasIds = $idsLab->merge($idsDx)->unique();

        if ($ordenesAgrupadasIds->isEmpty()) {
            $ordenesAgrupadasIds = collect([-1]);
        }

        $individuales = $this->cobroServicioRepository->obtenerOrdenesIndividuales($consulta_id, $cambio, $hoy, $ordenesAgrupadasIds, $estados);
        $valorTotalIndividuales = $individuales->sum('valor');

        return [
            'laboratorios' => $laboratorios,
            'ayudasDX' => $ayudasDX,
            'individuales' => $individuales,
            'total_individuales' => $valorTotalIndividuales ?? 0,
        ];
    }


      public function listarOrdenesACobrar(int $consulta_id)
    {
        $hoy = now();
        $cambio = now()->subDays(180);
        $estados = [1, 4]; // Estados que se consideran para cobro

        [$laboratorios, $idsLab] = $this->cobroServicioRepository->obtenerOrdenesAgrupadas($consulta_id, 45, $cambio, $hoy, $estados);
        [$ayudasDX, $idsDx] = $this->cobroServicioRepository->obtenerOrdenesAgrupadas($consulta_id, 46, $cambio, $hoy, $estados);

        $ordenesAgrupadasIds = $idsLab->merge($idsDx)->unique();

        if ($ordenesAgrupadasIds->isEmpty()) {
            $ordenesAgrupadasIds = collect([-1]);
        }

        $individuales = $this->cobroServicioRepository->obtenerOrdenesIndividuales($consulta_id, $cambio, $hoy, $ordenesAgrupadasIds, $estados);
        $valorTotalIndividuales = $individuales->sum('valor');

        return [
            'laboratorios' => $laboratorios,
            'ayudasDX' => $ayudasDX,
            'individuales' => $individuales,
            'total_individuales' => $valorTotalIndividuales ?? 0,
        ];
    }
}
