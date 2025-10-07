<?php

namespace App\Http\Modules\Medicamentos\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Modules\Afiliados\Models\Afiliado;
use App\Http\Modules\Afiliados\Repositories\AfiliadoRepository;
use App\Http\Modules\CobroFacturas\Services\CobroFacturasService;
use App\Http\Modules\Consultas\Models\Consulta;
use App\Http\Modules\Contratos\Services\ContratoService;
use App\Http\Modules\LogConsolidados\Services\LogConsolidadoService;
use App\Http\Modules\Medicamentos\Models\BodegaMedicamento;
use App\Http\Modules\Medicamentos\Models\Lote;
use App\Http\Modules\Medicamentos\Repositories\OrdenamientoRepository;
use App\Http\Modules\Medicamentos\Requests\CobroServicioRequest;
use App\Http\Modules\Medicamentos\Requests\DispensarOrdenamientoRequest;
use App\Http\Modules\Medicamentos\Requests\FiltroPrestadoresRequest;
use App\Http\Modules\Medicamentos\Requests\FirmaConsentimientosRequest;
use App\Http\Modules\Medicamentos\Requests\FirmaLaboratorioRequest;
use App\Http\Modules\Movimientos\Models\DetalleMovimiento;
use App\Http\Modules\Movimientos\Models\Movimiento;
use App\Http\Modules\Ordenamiento\Models\Orden;
use App\Http\Modules\Ordenamiento\Models\OrdenArticulo;
use App\Http\Modules\Ordenamiento\Models\OrdenCodigoPropio;
use App\Http\Modules\Ordenamiento\Models\OrdenProcedimiento;
use App\Http\Modules\Ordenamiento\Models\TipoOrden;
use App\Http\Modules\Ordenamiento\Repositories\OrdenArticuloIntrahospitalarioRepository;
use App\Http\Modules\Ordenamiento\Repositories\OrdenArticuloRepository;
use App\Http\Modules\Ordenamiento\Repositories\OrdenCodigoPropioRepository;
use App\Http\Modules\Ordenamiento\Repositories\OrdenProcedimientoRepository;
use App\Http\Modules\Ordenamiento\Requests\GenerarOrdenamientoIntrahospitalarioRequest;
use App\Http\Modules\Ordenamiento\Requests\AgregarNotaAdicionalOrdenCodigosPropiosRequest;
use App\Http\Modules\Ordenamiento\Requests\AgregarNotaAdicionalOrdenServiciosRequest;
use App\Http\Modules\Ordenamiento\Requests\AgregarNuevosCodigosPropiosRequest;
use App\Http\Modules\Ordenamiento\Requests\AgregarNuevosServiciosRequest;
use App\Http\Modules\Ordenamiento\Requests\CambiarCodigoPropioOrdenRequest;
use App\Http\Modules\Ordenamiento\Requests\CambiarDireccionamientoCodigosPropiosRequest;
use App\Http\Modules\Ordenamiento\Requests\CambiarDireccionamientoMedicamentosRequest;
use App\Http\Modules\Ordenamiento\Requests\CambiarDireccionamientoServiciosRequest;
use App\Http\Modules\Ordenamiento\Requests\CambiarServicioOrdenRequest;
use App\Http\Modules\Ordenamiento\Services\OrdenamientoService;
use App\Http\Modules\PDF\Controllers\PDFController;
use App\Http\Modules\PDF\Services\PdfService;
use App\Http\Requests\ConsolidadoFormulasRequest;
use App\Http\Requests\SetPendienteOrdenArticuloRequets;
use App\Jobs\CombinarConsolidadoFormulas;
use App\Jobs\ComprimirCarpeta;
use App\Jobs\ConsolidadoFormula;
use App\Jobs\FinalizarConsolidadoFormulas;
use App\Jobs\SubirArchivo;
use App\Jobs\SubirConsolidadoFormulas;
use App\Mail\ZipFormulasError;
use App\Traits\ArchivosTrait;
use Carbon\Carbon;
use Error;
use Illuminate\Bus\Batch;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Bus;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use Rap2hpoutre\FastExcel\FastExcel;
use Throwable;

class OrdenamientoController extends Controller
{
    use ArchivosTrait;

    protected $ordenamientoService;
    protected $ordenamientoRepository;
    protected $ordenProcedimientoRepository;
    protected $ordenArticuloRepository;
    protected $ordenCodigoPropioRepository;


    public function __construct(
        OrdenamientoService $ordenamientoService,
        OrdenamientoRepository $ordenamientoRepository,
        OrdenProcedimientoRepository $ordenProcedimientoRepository,
        OrdenArticuloRepository $ordenArticuloRepository,
        OrdenCodigoPropioRepository $ordenCodigoPropioRepository,
        protected AfiliadoRepository $afiliadoRepository,
        protected ContratoService $contratoService,
        private readonly OrdenArticuloIntrahospitalarioRepository $ordenArticuloIntrahospitalarioRepository,
        protected PdfService $pdfService,
        private readonly CobroFacturasService $cobroFacturasService,
        protected LogConsolidadoService $logConsolidadoService
    ) {
        $this->ordenamientoService = $ordenamientoService;
        $this->ordenamientoRepository = $ordenamientoRepository;
        $this->ordenProcedimientoRepository = $ordenProcedimientoRepository;
        $this->ordenArticuloRepository = $ordenArticuloRepository;
        $this->ordenCodigoPropioRepository = $ordenCodigoPropioRepository;
    }

    public function generarOrdenamiento($idConsulta, $tipo, Request $request)
    {
        try {
            $data = $this->ordenamientoService->generarOrden($idConsulta, $tipo, $request->all());
            return response()->json(
                [
                    'mensaje' => 'Ordenamiento cargado con éxito',
                    'type' => 'success',
                    'ordenServicios' => $data
                ],
                Response::HTTP_OK
            );
        } catch (\Throwable $th) {
            return response()->json([
                'res' => false,
                'error' => $th->getMessage(),
                'mensaje' => 'Error al generar las ordenes',
            ], Response::HTTP_BAD_REQUEST);
        }
    }

    public function ordenesActivas($idConsulta, $tipo)
    {
        try {
            $resultados = [];
            switch (intval($tipo)) {
                case 1:
                    $resultados = OrdenArticulo::select('orden_articulos.*')->with(['codesumi', 'estado', 'rep'])->join('ordenes as o', 'o.id', 'orden_articulos.orden_id')->where('o.consulta_id', $idConsulta)->where('o.tipo_orden_id', 1)->get();
                    break;
                case 2:
                    $resultados = OrdenProcedimiento::select('orden_procedimientos.*')->with(['cup', 'estado', 'rep', 'orden.consulta.afiliado'])->join('ordenes as o', 'o.id', 'orden_procedimientos.orden_id')->where('o.consulta_id', $idConsulta)->get();
                    break;
                case 3:
                    $resultados = OrdenArticulo::select('orden_articulos.*', 'o.nombre_esquema', 'o.ciclo', 'o.ciclo_total')->with(['codesumi', 'estado'])->join('ordenes as o', 'o.id', 'orden_articulos.orden_id')->where('o.consulta_id', $idConsulta)->where('o.tipo_orden_id', 3)->where('o.estado_id', 1)->get();
                    break;
                case 4:
                    $resultados = OrdenCodigoPropio::select('orden_codigo_propios.cantidad', 'orden_codigo_propios.id', 'orden_codigo_propios.orden_id', 'orden_codigo_propios.codigo_propio_id', 'orden_codigo_propios.rep_id', 'orden_codigo_propios.estado_id', 'orden_codigo_propios.fecha_vigencia')->with(['codigoPropio', 'estado', 'rep'])->join('ordenes as o', 'o.id', 'orden_codigo_propios.orden_id')->where('o.consulta_id', $idConsulta)->where('o.tipo_orden_id', 3)->where('o.estado_id', 1)->get();
                    break;
            }
            return response()->json($resultados, Response::HTTP_OK);
        } catch (\Throwable $th) {
            return response()->json([
                'res' => false,
                'error' => $th->getMessage(),
                'mensaje' => 'Error al consultar las ordenes',
            ], Response::HTTP_BAD_REQUEST);
        }
    }

    public function historico(Request $request)
    {
        try {
            $result = $this->ordenamientoService->getHistorico($request->all());
            return response()->json($result, Response::HTTP_OK);
        } catch (\Throwable $th) {
            return response()->json([
                'res' => false,
                'mensaje' => 'Error al recuperar los tipos de ordenes',
                'error' => $th->getMessage(),
            ], Response::HTTP_BAD_REQUEST);
        }
    }


    public function tipos()
    {
        try {
            return response()->json(TipoOrden::all(), Response::HTTP_OK);
        } catch (\Throwable $th) {
            return response()->json([
                'res' => false,
                'mensaje' => 'Error al recuperar los tipos de ordenes',
            ], Response::HTTP_BAD_REQUEST);
        }
    }

    public function detalleOrdenamientoPorConsulta($consulta)
    {
        try {
            $ordenes = $this->ordenamientoService->detalleOrdenamientoPorConsulta($consulta);
            return response()->json($ordenes, Response::HTTP_OK);
        } catch (\Throwable $th) {
            return response()->json([
                'error' => $th->getMessage(),
                'mensaje' => 'Error al consultar las ordenes',
            ], Response::HTTP_BAD_REQUEST);
        }
    }

    /**
     * lista ordenamientos para modulo autogestion segun el numero de la cedula del paciente
     * @param Request $request
     * @return Response
     * @author jdss
     */

    public function ordenMedicamnetosAutogestion(Request $request)
    {
        try {
            $ordenes = $this->ordenamientoRepository->ordenMedicamnetosAutogestion($request->all());
            return response()->json($ordenes, Response::HTTP_OK);
        } catch (\Throwable $th) {
            return response()->json([
                'error' => $th->getMessage(),
                'mensaje' => 'Error al consultar las ordenes',
            ], Response::HTTP_BAD_REQUEST);
        }
    }


    /**
     * lista servicios para modulo autogestion segun el numero de la cedula del paciente
     * @param Request $request
     * @return Response
     * @author jdss
     */

    public function ordenServiciosAutogestion(Request $request)
    {
        try {
            $ordenes = $this->ordenProcedimientoRepository->ordenServicioAutogestion($request->all());
            return response()->json($ordenes, Response::HTTP_OK);
        } catch (\Throwable $th) {
            return response()->json([
                'error' => $th->getMessage(),
                'mensaje' => 'Error al consultar las ordenes',
            ], Response::HTTP_BAD_REQUEST);
        }
    }


    /**
     * imprimir medicamentos
     * @param Request $request
     * @return Response
     * @author jdss
     */

    public function imprimirMedicamento(Request $request)
    {
        try {
            $ordenes = $this->ordenArticuloRepository->imprimirMedicamento($request->all());
            return response()->json($ordenes, Response::HTTP_OK);
        } catch (\Throwable $th) {
            return response()->json([
                'error' => $th->getMessage(),
                'mensaje' => 'Error al consultar las ordenes',
            ], Response::HTTP_BAD_REQUEST);
        }
    }

    public function generarPdf(Request $request)
    {
        try {
            $ordenes = $this->ordenamientoRepository->pdf($request->all());
            return $ordenes;
        } catch (\Throwable $th) {
            return response()->json([
                'error' => $th->getMessage(),
                'mensaje' => 'Error al consultar las ordenes',
            ], Response::HTTP_BAD_REQUEST);
        }
    }


    /**
     * imprimir servicios
     * @param Request $request
     * @return Response
     * @author jdss
     */

    public function imprimirServicio($orden_id)
    {
        try {
            $ordenes = $this->ordenProcedimientoRepository->imprimirServicio($orden_id);
            return response()->json($ordenes, Response::HTTP_OK);
        } catch (\Throwable $th) {
            return response()->json([
                'error' => $th->getMessage(),
                'mensaje' => 'Error al consultar las ordenes',
            ], Response::HTTP_BAD_REQUEST);
        }
    }

    public function historicoMedicamentos6meses(Request $request)
    {
        try {
            $ordenes = $this->ordenArticuloRepository->historicoMedicamentos($request->all());
            return response()->json($ordenes, Response::HTTP_OK);
        } catch (\Throwable $th) {
            return response()->json([
                'error' => $th->getMessage(),
                'mensaje' => 'Error al consultar las ordenes',
            ], Response::HTTP_BAD_REQUEST);
        }
    }

    public function HistoricoMedicamentosCronicos(Request $request)
    {
        try {
            $ordenes = $this->ordenArticuloRepository->MedicamentosCronicos6meses($request->all());
            return response()->json($ordenes, Response::HTTP_OK);
        } catch (\Throwable $th) {
            return response()->json([
                'error' => $th->getMessage(),
                'mensaje' => 'Error al consultar las ordenes',
            ], Response::HTTP_BAD_REQUEST);
        }
    }

    public function historicoOrden6meses(Request $request)
    {
        try {
            $ordenes = $this->ordenArticuloRepository->historicoOrden6meses($request->all());
            return response()->json($ordenes, Response::HTTP_OK);
        } catch (\Throwable $th) {
            return response()->json([
                'error' => $th->getMessage(),
                'mensaje' => 'Error al consultar las ordenes',
            ], Response::HTTP_BAD_REQUEST);
        }
    }

    public function listaOrdenesDispensacion($documento)
    {
        #consultamos el afiliado
        $afiliado = Afiliado::where('numero_documento', $documento)->first();
        if (!$afiliado) {
            throw new Error('El usuario que busca no ha sido encontrado.', 404);
        }

        $articulos = OrdenArticulo::with([
            'orden' => function ($query) {
                return $query->without('consulta');
            },
            'movimientos.detalleMovimientos'
        ])
            ->whereHas('orden.consulta', function ($query) use ($afiliado) {
                return $query->where('afiliado_id', $afiliado->id);
            })
            ->where('fecha_vigencia', '>', Carbon::now()->subDays(30))
            ->where('fecha_vigencia', '<', Carbon::now()->addDay())->get();


        return response()->json($articulos);
    }

    public function datosPrestador($OrdenProcedimiento, Request $request)
    {

        try {
            $ordenes = $this->ordenamientoService->datosPrestador($OrdenProcedimiento, $request->all());
            return response()->json($ordenes, Response::HTTP_OK);
        } catch (\Throwable $th) {
            return response()->json([
                'error' => $th->getMessage(),
                'mensaje' => 'Error al consultar las ordenes',
            ], Response::HTTP_BAD_REQUEST);
        }
    }

    public function cancelarEsquema(Request $request)
    {
        try {
            $orden = $this->ordenamientoRepository->cancelarEsquema($request->orden_id);
            return response()->json($orden, Response::HTTP_OK);
        } catch (\Throwable $th) {
            return response()->json([
                'error' => $th->getMessage(),
                'mensaje' => 'Error al consultar las ordenes',
            ], Response::HTTP_BAD_REQUEST);
        }
    }

    public function actualizarOrden(Request $request)
    {
        try {
            $orden = $this->ordenamientoRepository->actualizarOrden($request->orden_id, $request->fecha_agendamiento, $request->consulta_id);
            return response()->json($orden, Response::HTTP_OK);
        } catch (\Throwable $th) {
            return response()->json([
                'error' => $th->getMessage(),
                'mensaje' => 'Error al consultar las ordenes',
            ], Response::HTTP_BAD_REQUEST);
        }
    }

    public function aplicacionesAgendadas(Request $request)
    {
        try {
            $aplicaciones = $this->ordenamientoRepository->aplicacionesAgendadas($request);
            return response()->json($aplicaciones, Response::HTTP_OK);
        } catch (\Throwable $th) {
            return response()->json([
                'error' => $th->getMessage(),
                'mensaje' => 'Error al consultar las ordenes',
            ], Response::HTTP_BAD_REQUEST);
        }
    }

    public function finalizarAplicacion(Request $request)
    {
        try {
            $aplicaciones = $this->ordenamientoRepository->finalizarAplicacion($request);
            return response()->json($aplicaciones, Response::HTTP_OK);
        } catch (\Throwable $th) {
            return response()->json([
                'error' => $th->getMessage(),
                'mensaje' => 'Error al consultar las ordenes',
            ], Response::HTTP_BAD_REQUEST);
        }
    }

    public function consultaEsquemaPaciente(Request $request)
    {
        try {
            $aplicaciones = $this->ordenamientoRepository->consultaEsquemaPaciente($request);
            return response()->json($aplicaciones, Response::HTTP_OK);
        } catch (\Throwable $th) {
            return response()->json([
                'error' => $th->getMessage(),
                'mensaje' => 'Error al consultar las ordenes',
            ], Response::HTTP_BAD_REQUEST);
        }
    }

    public function suspenderEsquema(Request $request)
    {
        try {
            $aplicaciones = $this->ordenamientoRepository->suspenderEsquema($request);
            return response()->json($aplicaciones, Response::HTTP_OK);
        } catch (\Throwable $th) {
            return response()->json([
                'error' => $th->getMessage(),
                'mensaje' => 'Error al consultar las ordenes',
            ], Response::HTTP_BAD_REQUEST);
        }
    }

    public function suspender(Request $request)
    {
        try {
            $aplicaciones = $this->ordenamientoRepository->suspender($request);
            return response()->json($aplicaciones, Response::HTTP_OK);
        } catch (\Throwable $th) {
            return response()->json([
                'error' => $th->getMessage(),
                'mensaje' => 'Error al consultar las ordenes',
            ], Response::HTTP_BAD_REQUEST);
        }
    }

    public function asignarDireccionamiento(Request $request)
    {
        try {
            $direccionamiento = $this->ordenamientoService->direccionarOrden($request);
            return response()->json($direccionamiento, Response::HTTP_OK);
        } catch (\Throwable $th) {
            return response()->json([
                'error' => $th->getMessage(),
                'mensaje' => 'Error al consultar las ordenes',
            ], Response::HTTP_BAD_REQUEST);
        }
    }

    public function cobroOrdenes(Request $request)
    {
        try {
            $cobro = $this->ordenamientoService->cobrarOrden($request);
            return response()->json($cobro, Response::HTTP_OK);
        } catch (\Throwable $th) {
            return response()->json([
                'error' => $th->getMessage(),
                'mensaje' => 'Error al consultar las ordenes',
            ], Response::HTTP_BAD_REQUEST);
        }
    }

    public function exportarServicios(Request $request)
    {
        try {
            $evento = $this->ordenamientoRepository->exportarServicios($request);
            return $evento;
        } catch (\Throwable $th) {
            return response()->json([
                'res' => false,
                'mensaje' => 'Error al recuperar la información.',
                'error' => $th->getMessage()
            ], Response::HTTP_BAD_REQUEST);
        }
    }

    public function exportarMedicamentos(Request $request)
    {
        try {
            $evento = $this->ordenamientoRepository->exportarMedicamentos($request);
            return $evento;
        } catch (\Throwable $th) {
            return response()->json([
                'res' => false,
                'mensaje' => 'Error al recuperar la información.',
                'error' => $th->getMessage()
            ], Response::HTTP_BAD_REQUEST);
        }
    }

    public function actualizarRep(Request $request)
    {
        try {
            $direccionamiento = $this->ordenProcedimientoRepository->actualizarRep($request);
            return response()->json($direccionamiento, Response::HTTP_OK);
        } catch (\Throwable $th) {
            return response()->json([
                'error' => $th->getMessage(),
                'mensaje' => 'Error al consultar las ordenes',
            ], Response::HTTP_BAD_REQUEST);
        }
    }

    public function actualizarCantidad(Request $request)
    {
        try {
            $orden = $this->ordenProcedimientoRepository->actualizarCantidad($request);
            return response()->json($orden, Response::HTTP_OK);
        } catch (\Throwable $th) {
            return response()->json([
                'error' => $th->getMessage(),
                'mensaje' => 'Error al actualizar la cantidad de ordenes',
            ], Response::HTTP_BAD_REQUEST);
        }
    }

    public function actualizarCup(Request $request)
    {
        try {
            $orden = $this->ordenProcedimientoRepository->actualizarCup($request);
            return response()->json($orden, Response::HTTP_OK);
        } catch (\Throwable $th) {
            return response()->json([
                'error' => $th->getMessage(),
                'mensaje' => 'Error al actualizar el cup de las ordenes',
            ], Response::HTTP_BAD_REQUEST);
        }
    }

    public function actualizarVigencia(Request $request)
    {
        try {
            $orden = $this->ordenProcedimientoRepository->actualizarVigencia($request);
            return response()->json($orden, Response::HTTP_OK);
        } catch (\Throwable $th) {
            return response()->json([
                'error' => $th->getMessage(),
                'mensaje' => 'Error al actualizar la vigencia de la orden',
            ], Response::HTTP_BAD_REQUEST);
        }
    }

    public function notaAdicional(Request $request)
    {
        try {
            $orden = $this->ordenProcedimientoRepository->notaAdicional($request);
            return response()->json($orden, Response::HTTP_OK);
        } catch (\Throwable $th) {
            return response()->json([
                'error' => $th->getMessage(),
                'mensaje' => 'Error al crear la nota adicional',
            ], Response::HTTP_BAD_REQUEST);
        }
    }

    public function actualizarRepCodigoPropio(Request $request)
    {
        try {
            $direccionamiento = $this->ordenCodigoPropioRepository->actualizarRepCodigoPropio($request);
            return response()->json($direccionamiento, Response::HTTP_OK);
        } catch (\Throwable $th) {
            return response()->json([
                'error' => $th->getMessage(),
                'mensaje' => 'Error al consultar las ordenes',
            ], Response::HTTP_BAD_REQUEST);
        }
    }

    public function actualizarRepMedicamento(Request $request)
    {
        try {
            $direccionamiento = $this->ordenArticuloRepository->actualizarRep($request);
            return response()->json($direccionamiento, Response::HTTP_OK);
        } catch (\Throwable $th) {
            return response()->json([
                'error' => $th->getMessage(),
                'mensaje' => 'Error al consultar las ordenes',
            ], Response::HTTP_BAD_REQUEST);
        }
    }

    public function medicamentosDipensarPrestador(Request $request)
    {
        try {
            $consulta = $this->ordenProcedimientoRepository->medicamentoPrestdor($request);
            return response()->json($consulta, Response::HTTP_OK);
        } catch (\Throwable $th) {
            return response()->json([
                'error' => $th->getMessage(),
                'mensaje' => 'Error al consultar las ordenes',
            ], Response::HTTP_BAD_REQUEST);
        }
    }


    public function detalleMedicamentosPrestador($orden_id)
    {
        try {
            $consulta = $this->ordenProcedimientoRepository->detalleMedicamentoPrestdor($orden_id);
            return response()->json($consulta, Response::HTTP_OK);
        } catch (\Throwable $th) {
            return response()->json([
                'error' => $th->getMessage(),
                'mensaje' => 'Error al consultar las ordenes',
            ], Response::HTTP_BAD_REQUEST);
        }
    }

    public function dispensarProveedor(Request $request)
    {
        try {
            $consulta = $this->ordenProcedimientoRepository->dispensarMedicamentoPrestdor($request);
            return response()->json($consulta, Response::HTTP_OK);
        } catch (\Throwable $th) {
            return response()->json([
                'error' => $th->getMessage(),
                'mensaje' => 'Error al consultar las ordenes',
            ], Response::HTTP_BAD_REQUEST);
        }
    }

    /**
     * lista las ordenes segun el afiliado
     * @param Request $request
     * @param afiliado_id
     * @return Response
     */
    public function listarOrdenesPorAfiliado(Request $request, $afiliado_id)
    {
        try {
            $aplicaciones = $this->ordenamientoService->listarOrdenesPorAfiliado($afiliado_id);
            return response()->json($aplicaciones);
        } catch (\Throwable $th) {
            return response()->json([
                'error' => $th->getMessage(),
                'mensaje' => 'Error al consultar las ordenes',
            ], Response::HTTP_BAD_REQUEST);
        }
    }

    /**
     * lista los articulos segun la orden y los estados
     * @param Request $request
     * @param orden_id
     * @param estados
     * @return Response
     */
    public function listarArticulosPorAfiliado(Request $request, $afiliado_id, $estados = [])
    {
        try {
            $aplicaciones = $this->ordenamientoService->listarArticulosPorAfiliado($afiliado_id, $estados);
            return response()->json($aplicaciones);
        } catch (\Throwable $th) {
            return response()->json([
                'error' => $th->getMessage(),
                'mensaje' => 'Error al consultar las ordenes',
            ], Response::HTTP_BAD_REQUEST);
        }
    }


    /**
     * lista los articulos segun la orden y los estados
     * @param Request $request
     * @param orden_id
     * @param estados
     * @return Response
     */
    public function listarArticulosPorOrden(Request $request, $orden_id, $estado = null)
    {
        try {
            $aplicaciones = $this->ordenamientoService->listarArticulosPorOrden($orden_id, $estado);
            return response()->json($aplicaciones);
        } catch (\Throwable $th) {
            return response()->json([
                'error' => $th->getMessage(),
                'mensaje' => 'Error al consultar las ordenes',
            ], Response::HTTP_BAD_REQUEST);
        }
    }

    /**
     * lista los articulos activos segun la orden
     * @query $orden_id
     * @return Response
     */
    public function listarArticulosActivosPorOrden($orden_id)
    {
        try {
            $ordenArticulos = $this->ordenamientoService->listarArticulosActivosPorOrden($orden_id);
            return response()->json($ordenArticulos);
        } catch (\Throwable $th) {
            return response()->json([
                'error' => $th->getMessage(),
                'mensaje' => 'Error al consultar las ordenes',
            ]);
        }
    }

    /**
     * lista los articulos pendientes segun la orden
     * @param Request $request
     * @param orden_id
     * @param estados
     * @return Response
     */
    public function listarArticulosPorOrdenPendiente($orden_id)
    {
        try {
            $aplicaciones = $this->ordenamientoService->listarArticulosPendientesPorOrden($orden_id);
            return response()->json($aplicaciones);
        } catch (\Throwable $th) {
            return response()->json([
                'error' => $th->getMessage(),
                'mensaje' => 'Error al consultar las ordenes',
            ], Response::HTTP_BAD_REQUEST);
        }
    }


    /**
     * setea el estado de un orden articulo a pendiente
     * @param Request $request
     * @param OrdenArticulo $orden_articulo_id
     */
    public function setOrdenArticuloPendiente(SetPendienteOrdenArticuloRequets $request, OrdenArticulo $orden_articulo_id)
    {
        try {
            # Verificar si es el primer movimiento asociado a la orden
            $orden = Orden::where('id', $orden_articulo_id->orden_id)->first();
            $tieneMovimientos = Movimiento::where('orden_id', $orden->id)->exists();

            # Crear el nuevo movimiento
            Movimiento::create([
                'tipo_movimiento_id' => 17,
                'orden_id' => $request->orden_id,
                'orden_articulo_id' => $request->orden_articulo_id,
                'user_id' => auth()->user()->id,
            ]);

            # Guardar el timestamp del momento en que pasó a pendiente
            $orden_articulo_id->update([
                'estado_id' => 10, //pendiente
                'pendiente_at' => Carbon::now(),
                'bodega_responsable_id' => $request->bodega_responsable_id
            ]);

            # Solo actualizar fechas de vigencia si no existen movimientos previos
            if (!$tieneMovimientos) {
                # Obtener la consulta asociada a la orden
                $consulta = Consulta::where('id', $orden->consulta_id)->first();

                # Obtener todas las órdenes relacionadas a la consulta, excepto la orden actual
                $ordenesConsulta = Orden::where('consulta_id', $consulta->id)
                    ->where('id', '!=', $orden->id)  // Excluir la orden actual
                    ->get();

                # Calcular la diferencia de días entre la fecha actual y la fecha de vigencia de la orden
                $fechaActual = Carbon::now();
                $fechaVigencia = Carbon::parse($orden->fecha_vigencia);
                $diferenciaDias = $fechaVigencia->diffInDays($fechaActual);

                # Actualizar la fecha de vigencia de cada orden en la consulta (excepto la orden actual)
                foreach ($ordenesConsulta as $ordenConsulta) {
                    $nuevaFechaVigencia = Carbon::parse($ordenConsulta->fecha_vigencia)->addDays($diferenciaDias);
                    $ordenConsulta->update([
                        'fecha_vigencia' => $nuevaFechaVigencia
                    ]);

                    # Actualizar los OrdenArticulos relacionados con cada orden, excepto los de la orden actual
                    OrdenArticulo::where('orden_id', $ordenConsulta->id)
                        ->update([
                            'fecha_vigencia' => $nuevaFechaVigencia
                        ]);
                }
            }

            return response()->json($orden_articulo_id);
        } catch (\Throwable $th) {
            return response()->json([
                'error' => $th->getMessage(),
                'mensaje' => 'Error al actualizar el estado de la orden articulo',
            ], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    /**
     * setea el estado de un orden articulo a autorizado
     * @param Request $request
     * @param OrdenArticulo $orden_articulo_id
     */
    public function setOrdenArticuloAutorizado(Request $request, OrdenArticulo $orden_articulo_id)
    {
        try {
            $ordenes = $this->ordenamientoService->cambiarAutorizacionMipres($request->all(), $orden_articulo_id);
            return response()->json($ordenes);
        } catch (\Throwable $th) {
            return response()->json([
                'error' => $th->getMessage(),
                'mensaje' => 'Error al actualizar el estado de la orden articulo',
            ], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }


    /**
     * dispensar ACTIVOS
     */
    public function dispensar(DispensarOrdenamientoRequest $request)
    {
        try {
            DB::beginTransaction();

            # Verificar si es el primer movimiento asociado a la orden antes de crear el nuevo movimiento
            $articulo = OrdenArticulo::where('id', $request->orden_articulo_id)
                ->without('codesumi')
                ->first();
            $orden = Orden::where('id', $articulo->orden_id)->first();
            $tieneMovimientos = Movimiento::where('orden_id', $orden->id)->exists();

            # Crear el nuevo movimiento
            $movimiento = Movimiento::create([
                'tipo_movimiento_id' => 5,
                'bodega_origen_id' => $request->bodega_id,
                'orden_id' => $request->orden_id,
                'user_id' => $request->user()->id,
                'orden_articulo_id' => $request->orden_articulo_id
            ]);

            $cantidadTotal = 0;

            foreach ($request->lotes as $lote) {
                # Procesar cada lote
                $lote_consulta = Lote::where('id', $lote['id'])->first();
                $cantidadRestante = $lote_consulta->cantidad - $lote['cantidad'];
                if ($cantidadRestante < 0) {
                    throw new Error('La cantidad disponible en este lote, no permite dispensar la cantidad requerida.', 422);
                }

                # Actualizar la cantidad en la bodega
                $bodemaMedicamento = BodegaMedicamento::find($lote_consulta->bodega_medicamento_id);
                $cantidadRestanteBodega = $bodemaMedicamento->cantidad_total - $lote['cantidad'];
                $bodemaMedicamento->update([
                    'cantidad_total' => $cantidadRestanteBodega
                ]);

                # Crear detalle del movimiento
                DetalleMovimiento::create([
                    'movimiento_id' => $movimiento->id,
                    'bodega_medicamento_id' => $lote_consulta->bodega_medicamento_id,
                    'cantidad_anterior' => $lote_consulta->cantidad,
                    'cantidad_solicitada' => $lote['cantidad'],
                    'cantidad_final' => $cantidadRestante,
                    'lote_id' => $lote_consulta->id
                ]);

                # Actualizar la cantidad del lote
                $lote_consulta->update([
                    'cantidad' => $cantidadRestante
                ]);

                $cantidadTotal += $lote['cantidad'];
            }

            # Actualizar el artículo de la orden
            $diferencia = $articulo->cantidad_medico - $cantidadTotal;
            if ($diferencia < 0) {
                throw new Error('La cantidad dispensada supera la cantidad mensual disponible.', 422);
            }
            $articulo->update([
                'cantidad_mensual_disponible' => $diferencia,
                'cantidad_entregada' => $cantidadTotal,
                'estado_id' => $diferencia > 0 ? 18 : 34,
            ]);

            # Solo actualizar fechas de vigencia si no existen movimientos previos
            if (!$tieneMovimientos) {
                # Obtener la consulta asociada a la orden
                $consulta = Consulta::where('id', $orden->consulta_id)->first();

                # Extraer la parte numérica inicial de la paginación actual
                $paginacionActual = intval(explode('/', $orden->paginacion)[0]);

                # Obtener todas las órdenes relacionadas a la consulta, excepto las órdenes anteriores a la actual
                $ordenesConsulta = Orden::where('consulta_id', $consulta->id)
                    ->whereRaw('CAST(SPLIT_PART(paginacion, \'/\', 1) AS INTEGER) > ?', [$paginacionActual])
                    ->get();

                # Calcular la diferencia de días entre la fecha actual y la fecha de vigencia
                $fechaActual = Carbon::now();
                $fechaVigencia = Carbon::parse($orden->fecha_vigencia);
                $diferenciaDias = $fechaVigencia->diffInDays($fechaActual);

                # Actualizar la fecha de vigencia de cada orden posterior en la consulta
                foreach ($ordenesConsulta as $ordenConsulta) {
                    $nuevaFechaVigencia = Carbon::parse($ordenConsulta->fecha_vigencia)->addDays($diferenciaDias);
                    $ordenConsulta->update([
                        'fecha_vigencia' => $nuevaFechaVigencia
                    ]);
                }
            }
            DB::commit();
            // OrdenDispensada::dispatch($movimiento);
            return response()->json($articulo);
        } catch (\Throwable $th) {
            DB::rollBack();
            return response()->json([
                'error' => $th->getMessage(),
                'mensaje' => '',
            ], 400);
        }
    }


    public function dispensarPendiente(Request $request)
    {

        try {
            DB::beginTransaction();
            // Crear el registro en Movimientos
            $movimiento = Movimiento::create([
                'tipo_movimiento_id' => 5,
                'bodega_origen_id' => $request->bodega_id,
                'orden_id' => $request->orden_id,
                'user_id' => $request->user()->id,
                'orden_articulo_id' => $request->orden_articulo_id
            ]);

            $cantidadTotal = 0;

            foreach ($request->lotes as $lote) {
                // Obtener el lote correspondiente
                $lote_consulta = Lote::where('id', $lote['id'])->first();

                // Restar la cantidad dispensada a la disponible del lote, validando que no supere la cantidad disponible.
                $cantidadRestante = $lote_consulta->cantidad - $lote['cantidad'];
                if ($cantidadRestante < 0) {
                    throw new Error('La cantidad que se quiere dispensar supera la cantidad disponible.', 422);
                }

                // Buscar el el BodegaMedicamento para descontar la cantidad
                $bodegaMedicamento = BodegaMedicamento::find($lote_consulta->bodega_medicamento_id);
                $cantidadRestanteBodega = $bodegaMedicamento->cantidad_total - $lote['cantidad'];
                $bodegaMedicamento->update([
                    'cantidad_total' => $cantidadRestanteBodega
                ]);

                // Crear un detalle del movimiento
                DetalleMovimiento::create([
                    'movimiento_id' => $movimiento->id,
                    'bodega_medicamento_id' => $lote_consulta->bodega_medicamento_id,
                    'cantidad_anterior' => $lote_consulta->cantidad,
                    'cantidad_solicitada' => $lote['cantidad'],
                    'cantidad_final' => $cantidadRestante,
                    'lote_id' => $lote_consulta->id
                ]);

                // Actualizar la cantidad del lote
                $lote_consulta->update([
                    'cantidad' => $cantidadRestante
                ]);

                //
                $cantidadTotal += $lote['cantidad'];
            }

            // Ir al OrdenArticulo y mover la Cantidad Mensual Disponible respecto a la Cantidad Dispensada
            $articulo = OrdenArticulo::where('id', $request->orden_articulo_id)->without('codesumi')->first();
            $diferencia = $articulo->cantidad_mensual_disponible - $cantidadTotal;

            if ($diferencia < 0) {
                throw new Error('La cantidad que se quiere dispensar supera la cantidad disponible.', 422);
            }

            $articulo->update([
                'cantidad_mensual_disponible' => $diferencia,
                // Sumar a la Cantidad Entregada lo que se ha dispensado esta vez
                'cantidad_entregada' => $articulo->cantidad_entregada + $cantidadTotal,
                'estado_id' => $diferencia > 0 ? 18 : 34,
            ]);

            // OrdenDispensada::dispatch($movimiento);

            DB::commit();
            return response()->json($articulo);
        } catch (\Throwable $th) {
            DB::rollBack();
            return response()->json([
                'error' => $th->getMessage(),
                'mensaje' => '',
            ], 400);
        }
    }


    /**
     * lista las ordenes segun el afiliado y el estado activo
     * @param Request $request
     * @param afiliado_id
     * @return Response
     */
    public function listarOrdenesActivas(Request $request, $afiliado_id)
    {
        try {
            $ordenes = $this->ordenamientoService->listarOrdenesActivas($afiliado_id);
            return response()->json($ordenes);
        } catch (\Throwable $th) {
            return response()->json([
                'error' => $th->getMessage(),
                'mensaje' => 'Error al consultar las ordenes',
            ], Response::HTTP_BAD_REQUEST);
        }
    }

    /**
     * lista las ordenes segun el afiliado y el estado activo
     * Modificado por Thomas Restrepo
     * @query afiliado_id
     * @return JsonResponse
     */
    public function listarOrdenesPendientes(Request $request, $afiliado_id)
    {
        try {
            $ordenes = $this->ordenamientoService->listarOrdenesPendientes($afiliado_id);
            return response()->json($ordenes);
        } catch (\Throwable $th) {
            return response()->json([
                'error' => $th->getMessage(),
                'mensaje' => 'Error al consultar las ordenes',
            ], Response::HTTP_BAD_REQUEST);
        }
    }

    /**
     * lista las ordenes segun el afiliado y el estado activo
     * @param Request $request
     * @param afiliado_id
     * @return Response
     */
    public function listarOrdenesProximas(Request $request, $afiliado_id)
    {
        try {
            $ordenes = $this->ordenamientoService->listarOrdenesProximas($afiliado_id);
            return response()->json($ordenes);
        } catch (\Throwable $th) {
            return response()->json([
                'error' => $th->getMessage(),
                'mensaje' => 'Error al consultar las ordenes',
            ], Response::HTTP_BAD_REQUEST);
        }
    }

    public function listarHorus1Activas(Request $request)
    {
        try {
            $ordenes = $this->ordenamientoService->listarHorus1Activas($request);
            return response()->json($ordenes);
        } catch (\Throwable $th) {
            return response()->json([
                'error' => $th->getMessage(),
                'mensaje' => 'Error al consultar las ordenes',
            ], Response::HTTP_BAD_REQUEST);
        }
    }

    public function transcribirFormulas(Request $request)
    {
        try {
            $ordenes = $this->ordenamientoService->transcripcionFormulas($request);
            return response()->json($ordenes);
        } catch (\Throwable $th) {
            return response()->json([
                'error' => $th->getMessage(),
                'mensaje' => 'Error al transcribir formulas',
            ], Response::HTTP_BAD_REQUEST);
        }
    }

    public function imprimirInteroperabilidad(Request $request)
    {
        try {
            $objPdf = new PDFController();
            #creamos un request por 4que la funcion de imprimir es un metodo de controlador
            // return response()->json($request->all());
            $objeto = new Request($request->all());
            $pdf = $objPdf->imprimir($objeto);
            return response()->json($pdf);
        } catch (\Throwable $th) {
            return response()->json($th->getMessage());
        }
    }

    public function ordenProcedimientoSede(Request $request)
    {
        try {
            $orden = $this->ordenProcedimientoRepository->ordenProcedimientoSede($request);
            return response()->json($orden, Response::HTTP_OK);
        } catch (\Throwable $th) {
            return response()->json([
                'error' => $th->getMessage(),
                'mensaje' => 'Error al consultar las ordenes de servicios',
            ], Response::HTTP_BAD_REQUEST);
        }
    }

    public function ordenCodigoPropioSede(Request $request)
    {
        try {
            $orden = $this->ordenCodigoPropioRepository->ordenCodigoPropioSede($request);
            return response()->json($orden, Response::HTTP_OK);
        } catch (\Throwable $th) {
            return response()->json([
                'error' => $th->getMessage(),
                'mensaje' => 'Error al consultar las ordenes de servicios',
            ], Response::HTTP_BAD_REQUEST);
        }
    }

    public function listarSuspension($ordenArticuloId)
    {
        try {
            $suspension = $this->ordenArticuloRepository->listarSuspension($ordenArticuloId);
            return response()->json($suspension);
        } catch (\Throwable $th) {
            return response()->json([
                'error' => $th->getMessage(),
                'mensaje' => 'Error al consultar la suspension del medicamento',
            ], Response::HTTP_BAD_REQUEST);
        }
    }

    /**
     * Lista las Ordenes de Servicios y Codigos Propios filtrando por el afiliado_id pasando este dato
     * al repositorio para obtener las ordenes y devolviendo una respuesta JSON.
     *
     * @param $afiliado_id Query Param que es el id del afiliado del cual se buscan las ordenes de
     * Servicios y Códigos Propios.
     * @return JsonResponse Respuesta JSON con las ordenes del afiliado o un error en caso de fallo.
     * @throws \Throwable Captura de cualquier excepción que pueda ocurrir durante el proceso.
     * @author Thomas Restrepo
     */
    public function listarOrdenesAfiliado($afiliado_id): JsonResponse
    {
        try {
            $respuesta = $this->ordenamientoRepository->listarOrdenesAfiliado($afiliado_id);
            return response()->json($respuesta);
        } catch (\Throwable $th) {
            return response()->json([
                'error' => $th->getMessage(),
                'mensaje' => 'Error al consultar las ordenes del afiliado',
            ], Response::HTTP_BAD_REQUEST);
        }
    }

    /**
     * Listar movimientos de dispensación por afiliado
     * @param $afiliadoId Query Param que es el id del afiliado del cual se buscan los movimientos de dispensación
     * @param $request Request que contiene los filtros de búsqueda
     * @return JsonResponse Respuesta JSON con los movimientos de dispensación o un error en caso de fallo
     * @throws \Throwable Captura de cualquier excepción que pueda ocurrir durante el proceso
     * @author Thomas Restrepo
     */

    public function listarMovimientosDispensacion($afiliadoId, Request $request): JsonResponse
    {
        try {
            $movimientos = $this->ordenamientoService->listarMovimientosDispensacion($afiliadoId, $request->all());
            return response()->json($movimientos);
        } catch (\Throwable $th) {
            return response()->json([
                'error' => $th->getMessage(),
                'mensaje' => 'Error al consultar los movimientos de dispensación',
            ], Response::HTTP_BAD_REQUEST);
        }
    }

    public function actualizarFechaVigencia($ordenId, Request $request): JsonResponse
    {
        try {
            $orden = $this->ordenamientoService->actualizarFechaVigencia($ordenId, $request->all());
            return response()->json($orden);
        } catch (\Throwable $th) {
            return response()->json([
                'error' => $th->getMessage(),
                'mensaje' => 'Error al actualizar la fecha de vigencia',
            ], Response::HTTP_BAD_REQUEST);
        }
    }


    public function parametrizarDomicilio($ordenArticuloId, Request $request): JsonResponse
    {
        try {
            $ordenArticulo = $this->ordenArticuloRepository->parametrizarDomicilio($ordenArticuloId, $request->all());
            return response()->json($ordenArticulo);
        } catch (\Throwable $th) {
            return response()->json([
                'error' => $th->getMessage(),
                'mensaje' => 'Error al parametrizar el domicilio del articulo',
            ], Response::HTTP_BAD_REQUEST);
        }
    }

    public function actualizarCodigoPropio(Request $request)
    {
        try {
            $orden = $this->ordenCodigoPropioRepository->actualizarCodigoPropio($request);
            return response()->json($orden, Response::HTTP_OK);
        } catch (\Throwable $th) {
            return response()->json([
                'error' => $th->getMessage(),
                'mensaje' => 'Error al actualizar el codigo propio de las ordenes',
            ], Response::HTTP_BAD_REQUEST);
        }
    }

    public function agregarNuevoCup($id, Request $request)
    {
        try {
            $orden = $this->ordenProcedimientoRepository->agregarCup($id, $request);
            return response()->json('Agregado con exito', Response::HTTP_OK);
        } catch (\Throwable $th) {
            return response()->json(['Error' => $th->getMessage()], Response::HTTP_BAD_REQUEST);
        }
    }

    public function agregarCodigoPropio($id, Request $request)
    {
        try {
            $orden = $this->ordenCodigoPropioRepository->agregarCodigoPropio($id, $request);
            return response()->json('Agregado con exito', Response::HTTP_OK);
        } catch (\Throwable $th) {
            return response()->json(['Error' => $th->getMessage()], Response::HTTP_BAD_REQUEST);
        }
    }

    public function actualizarEstado(Request $request)
    {
        try {
            $id = $request->input('id');
            $tipo = $request->input('tipo');
            $estado_id = $request->input('estado_id');
            $observacion = $request->input('observacion');
            $resultado = $this->ordenamientoService->actualizarEstado($id, $tipo, $estado_id, $observacion);
            return response()->json($resultado, Response::HTTP_OK);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Ocurrió un error al actualizar el estado: ' . $e->getMessage()], 500);
        }
    }

    public function cambioDireccionamientoMasivo(Request $request, $rep_id)
    {
        try {
            $direccionamiento = $this->ordenamientoService->cambioDireccionamientoMasivo($request->all(), $rep_id);
            return response()->json($direccionamiento, Response::HTTP_OK);
        } catch (\Throwable $th) {
            return response()->json([
                'error' => $th->getMessage(),
                'mensaje' => 'Ha ocurrido un Error al cambiar el Direccionamiento'
            ], Response::HTTP_BAD_REQUEST);
        }
    }

    /**
     * lista los ordenes_articulo por el estado_id 45
     * @param Request $request
     * @param $request
     * @return Response
     */
    public function buscarOrdenArticulo(Request $request)
    {
        try {
            $ordenArticulo = $this->ordenArticuloRepository->buscarOrdenArticulo($request->all());
            return response()->json($ordenArticulo, 200);
        } catch (\Throwable $th) {
            return response()->json([
                'error' => $th->getMessage(),
                'mensaje' => 'Ha ocurrido un Error al Filtrar los Articulos'
            ]);
        }
    }

    public function autorizarOrdenArticulo(Request $request, $id)
    {
        try {
            $ordenArticulo = $this->ordenamientoService->AutorizarOrdenArticulo($request->all(), $id);
            return response()->json($ordenArticulo, 200);
        } catch (\Throwable $th) {
            return response()->json([
                'error' => $th->getMessage(),
                'mensaje' => 'Ha ocurrido un Error al listar los Articulos'
            ], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    public function validarPeriodicidad(Request $request, $idConsulta)
    {
        try {
            $periodicidad = $this->ordenamientoService->validarPeriodicidad($request->all(), $idConsulta);
            return response()->json($periodicidad, 200);
        } catch (\Throwable $th) {
            return response()->json([
                'error' => $th->getMessage(),
                'mensaje' => 'Ha ocurrido un Error al validar la periodicidad'
            ], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    /**
     * envia una orden a fomag
     * @param Request $request
     * @param int $orden
     * @return Response
     * @author David Peláez
     */
    public function enviarFomag(Request $request, int $orden)
    {
        try {
            $orden = $this->ordenamientoService->enviarFomag($orden);
            return response()->json($orden, 200);
        } catch (\Throwable $th) {
            return response()->json([
                'error' => $th->getMessage(),
                'mensaje' => 'Ha ocurrido un error al enviar la orden a Fomag'
            ], 500);
        }
    }

    /**
     * lista los laboratorios de un afiliado
     * @param Request $request
     * @return Response
     * @authorJDss
     */
    public function consultarLaboratorio(Request $request)
    {
        try {
            $orden = $this->ordenProcedimientoRepository->consultarLaboratorio($request);
            return response()->json($orden, 200);
        } catch (\Throwable $th) {
            return response()->json([
                'error' => $th->getMessage(),
                'mensaje' => 'Ha ocurrido un error al listar los laboratorios'
            ], $th->getCode() ?? 500);
        }
    }

    /**
     * firma la orden
     * @param Request $request
     * @return Response
     * @authorJDss
     */
    public function firmar(FirmaLaboratorioRequest $request)
    {
        try {
            $orden = $this->ordenamientoService->firmar($request->validated());
            return response()->json($orden, 200);
        } catch (\Throwable $th) {
            return response()->json([
                'error' => $th->getMessage(),
                'mensaje' => 'Ha ocurrido un error al listar los laboratorios'
            ], $th->getCode() ?? 500);
        }
    }

    /**
     * Firma el consentimiento informado de varias ordenes de procedimientos
     * @param \App\Http\Modules\Medicamentos\Requests\FirmaLaboratorioRequest $request
     * @return JsonResponse|mixed
     */
    public function firmarConsentimientosProcedimientos(FirmaConsentimientosRequest $request)
    {
        try {

            $orden = $this->ordenamientoService->firmarConsentimientosOrdenes($request->validated());
            return response()->json([
                'mensaje' => 'Ordenamiento firmado correctamente'
            ], 200);
        } catch (\Throwable $th) {
            return response()->json([
                'error' => $th->getMessage(),
                'mensaje' => 'Ha ocurrido un error al firmar los laboratorios'
            ], 400);
        }
    }


    /**
     * Firma los procedimientos asociados a un numero de orden que requieran firma de consentimiento
     * @param \Illuminate\Http\Request $request
     * @return JsonResponse|mixed
     */
    public function firmarConsentimientosOrden(Request $request)
    {
        try {
            $orden = $this->ordenamientoService->firmarConsentimientosOrden($request->all());
            return response()->json([
                'mensaje' => 'Orden firmada correctamente',
                'data' => $orden
            ], Response::HTTP_OK);
        } catch (\Throwable $th) {
            return response()->json([
                'error' => $th->getMessage(),
                'mensaje' => 'Ha ocurrido un error al firmar la orden',
            ], Response::HTTP_BAD_REQUEST);
        }
    }

    public function ordenesMedicamentosAfiliado(Request $request)
    {
        try {
            $ordenes = $this->ordenamientoRepository->ordenesMedicamentosAfiliado($request->all());
            return response()->json($ordenes, Response::HTTP_OK);
        } catch (\Throwable $th) {
            return response()->json([
                'error' => $th->getMessage(),
                'mensaje' => 'Error al consultar las ordenes',
            ], Response::HTTP_BAD_REQUEST);
        }
    }

    public function ordenesProcedimientosAfiliado(Request $request)
    {
        try {
            $ordenes = $this->ordenamientoRepository->ordenesProcedimientosAfiliado($request->all());
            return response()->json($ordenes, Response::HTTP_OK);
        } catch (\Throwable $th) {
            return response()->json([
                'error' => $th->getMessage(),
                'mensaje' => 'Error al consultar las ordenes',
            ], Response::HTTP_BAD_REQUEST);
        }
    }

    public function firmaAfiliadoOrdenNegada(Request $request)
    {
        try {
            $firma = $this->ordenamientoService->firmaAfiliadoOrdenNegada($request);
            return response()->json($firma);
        } catch (\Throwable $th) {
            return response()->json(['error' => $th->getMessage(), 400]);
        }
    }


    public function verificarMipresCodesumi(Request $request)
    {
        try {
            $mipres = $this->ordenArticuloRepository->verificarMipresCodesumi($request);
            return response()->json($mipres);
        } catch (\Throwable $th) {
            return response()->json(['error' => $th->getMessage()], 400);
        }
    }

    public function ordenMedicamentosLineaBase(FiltroPrestadoresRequest $request)
    {
        try {
            $orden = $this->ordenProcedimientoRepository->ordenMedicamentosLineaBase($request->validated());
            return response()->json($orden, Response::HTTP_OK);
        } catch (\Throwable $th) {
            return response()->json([
                'error' => $th->getMessage(),
                'mensaje' => 'Error al consultar las ordenes de medicamentos',
            ], Response::HTTP_BAD_REQUEST);
        }
    }

    /**
     * Valida y genera una orden de medicamentos intrahospitalarios
     * @param GenerarOrdenamientoIntrahospitalarioRequest $request
     * @return JsonResponse
     * @throws \Throwable
     * @author Thomas
     */
    public function generarOrdenamientoIntrahospitalario(GenerarOrdenamientoIntrahospitalarioRequest $request): JsonResponse
    {
        try {
            $response = $this->ordenamientoService->generarOrdenamientoIntrahospitalario($request->validated());
            return response()->json($response, Response::HTTP_CREATED);
        } catch (\Throwable $th) {
            return response()->json([
                'error' => $th->getMessage(),
            ], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    /**
     * Lista los articulos intrahospitalario ordenados en una consulta
     * @param int $consultaId
     * @return JsonResponse
     * @throws \Throwable
     * @author Thomas
     */
    public function listarArticulosIntrahospitalariosOrdenadosConsulta(int $consultaId): JsonResponse
    {
        try {
            $response = $this->ordenArticuloIntrahospitalarioRepository->listarArticulosIntrahospitalariosOrdenadosConsulta($consultaId);
            return response()->json($response, Response::HTTP_OK);
        } catch (\Throwable $th) {
            return response()->json([
                'error' => $th->getMessage(),
            ], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    /**
     * Lista el histórico de un afiliado de ordenes intrahospitalarias por el ID del afiliado
     * @param int $afiliadoId
     * @param Request $request
     * @return JsonResponse
     * @throws \Throwable
     * @author Thomas
     */
    public function listarHistoricoOrdenesIntrahospitalariasAfiliado(int $afiliadoId, Request $request): JsonResponse
    {
        try {
            $response = $this->ordenArticuloIntrahospitalarioRepository->listarHistoricoOrdenesIntrahospitalariasAfiliado($afiliadoId, $request->all());
            return response()->json($response, Response::HTTP_OK);
        } catch (\Throwable $th) {
            return response()->json([
                'error' => $th->getMessage(),
            ], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    /**
     * Lista el histórico de un afiliado de ordenes intrahospitalarias por el tipo y numero de documento del afiliado
     * @param int $tipoDocumentoId
     * @param string $numeroDocumento
     * @param Request $request
     * @return JsonResponse
     * @throws \Throwable
     * @author Thomas
     */
    public function listarHistoricoOrdenesIntrahospitalarias(int $tipoDocumentoId, string $numeroDocumento, Request $request): JsonResponse
    {
        try {
            $response = $this->ordenArticuloIntrahospitalarioRepository->listarHistoricoOrdenesIntrahospitalarias($tipoDocumentoId, $numeroDocumento, $request->all());
            return response()->json($response, Response::HTTP_OK);
        } catch (\Throwable $th) {
            return response()->json([
                'error' => $th->getMessage(),
            ], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    /**
     * Lista el histórico de un afiliado de recibos de caja por el tipo y numero de documento del afiliado
     * @param int $tipoDocumentoId
     * @param string $numeroDocumento
     * @param Request $request
     * @return JsonResponse
     * @throws \Throwable
     * @author kobatime
     */
    public function historicoRecibosCaja(int $tipoDocumentoId, string $numeroDocumento, Request $request): JsonResponse
    {
        try {
            $response = $this->cobroFacturasService->listarHistorico($tipoDocumentoId, $numeroDocumento, $request->all());
            return response()->json($response, Response::HTTP_OK);
        } catch (\Throwable $th) {
            return response()->json([
                'error' => $th->getMessage(),
            ], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    public function serviciosVigentes($idAfiliado)
    {
        try {
            $serviciosVigentes = $this->ordenProcedimientoRepository->serviciosVigentes($idAfiliado);
            $otrosServiciosVigentes = $this->ordenCodigoPropioRepository->serviciosVigentes($idAfiliado);
            return response()->json(array_merge($serviciosVigentes->toArray(), $otrosServiciosVigentes->toArray()));
        } catch (\Throwable $th) {
            return response()->json($th->getMessage(), 400);
        }
    }

    public function serviciosVigentesAdmision($idAfiliado)
    {
        try {
            $serviciosVigentes = $this->ordenProcedimientoRepository->serviciosVigentesAdmisiones($idAfiliado);
            //$otrosServiciosVigentes = $this->ordenCodigoPropioRepository->serviciosVigentes($idAfiliado);
            //, $otrosServiciosVigentes->toArray()
            return response()->json(array_merge($serviciosVigentes->toArray()));
        } catch (\Throwable $th) {
            return response()->json($th->getMessage(), 400);
        }
    }

    public function ordenesPorCobrar(int $consulta_id)
    {
        try {
            $ordenes = $this->ordenamientoService->listarOrdenesPorCobrar($consulta_id);
            return response()->json($ordenes, Response::HTTP_OK);
        } catch (\Throwable $th) {
            return response()->json([
                'error' => $th->getMessage(),
                'mensaje' => 'Error al consultar las ordenes por cobrar',
            ], Response::HTTP_BAD_REQUEST);
        }
    }

    public function ordenesACobrar(int $consulta_id)
    {
        try {
            $ordenes = $this->ordenamientoService->listarOrdenesACobrar($consulta_id);
            return response()->json($ordenes, Response::HTTP_OK);
        } catch (\Throwable $th) {
            return response()->json([
                'error' => $th->getMessage(),
                'mensaje' => 'Error al consultar las ordenes A cobrar',
            ], Response::HTTP_BAD_REQUEST);
        }
    }

    public function cobroServicio(int $afiliado_id, CobroServicioRequest $request)
    {
        try {
            $factura = $this->ordenamientoService->registrarCobro($afiliado_id, $request->validated());
            return response()->json($factura, Response::HTTP_OK);
        } catch (\Throwable $th) {
            return response()->json($th->getMessage(), 400);
        }
    }

    /**
     * Lista los servicios de una orden pendientes de auditoria
     * @param int $afiliadoId
     * @param int $ordenId
     * @return JsonResponse
     * @throws \Throwable
     * @author Thomas
     */
    public function listarServiciosPorAuditar(int $afiliadoId, int $ordenId): JsonResponse
    {
        try {
            $articulos = $this->ordenProcedimientoRepository->listarServiciosPorAuditar($afiliadoId, $ordenId);
            return response()->json($articulos, Response::HTTP_OK);
        } catch (\Throwable $th) {
            return response()->json([
                'error' => $th->getMessage(),
                'mensaje' => 'Error al consultar las ordenes',
            ], Response::HTTP_BAD_REQUEST);
        }
    }

    /**
     * Agregar nota adicional a ordenes de servicios
     * @param AgregarNotaAdicionalOrdenServiciosRequest $request
     * @return JsonResponse
     * @throws \Throwable
     * @author Thomas
     */
    public function agregarNotaAdicionalOrdenServicios(AgregarNotaAdicionalOrdenServiciosRequest $request): JsonResponse
    {
        try {
            $response = $this->ordenamientoService->agregarNotaAdicionalOrdenServicios($request->validated());
            return response()->json($response, Response::HTTP_OK);
        } catch (\Throwable $th) {
            return response()->json(['Error' => $th->getMessage()], 500);
        }
    }

    /**
     * Lista las notas adicionales de una orden de servicios
     * @param int $ordenProcedimientoId
     * @return JsonResponse
     * @throws \Throwable
     * @author Thomas
     */
    public function listarNotasAdicionalesOrdenServicio(int $ordenProcedimientoId): JsonResponse
    {
        try {
            $notas = $this->ordenProcedimientoRepository->listarNotasAdicionalesOrdenServicio($ordenProcedimientoId);
            return response()->json($notas, Response::HTTP_OK);
        } catch (\Throwable $th) {
            return response()->json(['Error' => $th->getMessage()], 500);
        }
    }

    /**
     * Cambiar el direccionamiento de servicios
     * @param CambiarDireccionamientoServiciosRequest $request
     * @return JsonResponse
     * @throws \Throwable
     * @author Thomas
     */
    public function cambiarDireccionamientoServicios(CambiarDireccionamientoServiciosRequest $request): JsonResponse
    {
        try {
            $response = $this->ordenamientoService->cambiarDireccionamientoServicios($request->validated());
            return response()->json($response, Response::HTTP_OK);
        } catch (\Throwable $th) {
            return response()->json(['error' => $th->getMessage()], 500);
        }
    }

    /**
     * Agregar nuevos servicios a una orden desde autorizaciones
     * @param AgregarNuevosServiciosRequest $request
     * @return JsonResponse
     * @throws \Throwable
     * @author Thomas
     */
    public function agregarNuevosServicios(AgregarNuevosServiciosRequest $request): JsonResponse
    {
        try {
            $response = $this->ordenamientoService->agregarNuevosServicios($request->validated());
            return response()->json($response, Response::HTTP_OK);
        } catch (\Throwable $th) {
            return response()->json(['error' => $th->getMessage()], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    /**
     * Lista los códigos propios de una orden pendientes de auditoria
     * @param int $afiliadoId
     * @param int $ordenId
     * @return JsonResponse
     * @throws \Throwable
     * @author Thomas
     */
    public function listarCodigosPropiosPorAuditar(int $afiliadoId, int $ordenId): JsonResponse
    {
        try {
            $articulos = $this->ordenCodigoPropioRepository->listarCodigosPropiosPorAuditar($afiliadoId, $ordenId);
            return response()->json($articulos, Response::HTTP_OK);
        } catch (\Throwable $th) {
            return response()->json([
                'error' => $th->getMessage(),
                'mensaje' => 'Error al consultar las ordenes',
            ], Response::HTTP_BAD_REQUEST);
        }
    }

    /**
     * Agregar nuevos códigos propios a una orden
     * @param AgregarNuevosCodigosPropiosRequest $request
     * @return JsonResponse
     * @throws \Throwable
     * @author Thomas
     */
    public function agregarNuevosCodigosPropios(AgregarNuevosCodigosPropiosRequest $request): JsonResponse
    {
        try {
            $response = $this->ordenamientoService->agregarNuevosCodigosPropios($request->validated());
            return response()->json($response, Response::HTTP_OK);
        } catch (\Throwable $th) {
            return response()->json(['error' => $th->getMessage()], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    /**
     * Cambiar el direccionamiento de códigos propios
     * @param CambiarDireccionamientoCodigosPropiosRequest $request
     * @return JsonResponse
     * @throws \Throwable
     * @author Thomas
     */
    public function cambiarDireccionamientoCodigosPropios(CambiarDireccionamientoCodigosPropiosRequest $request): JsonResponse
    {
        try {
            $response = $this->ordenamientoService->cambiarDireccionamientoCodigosPropios($request->validated());
            return response()->json($response, Response::HTTP_OK);
        } catch (\Throwable $th) {
            return response()->json(['error' => $th->getMessage()], 500);
        }
    }

    /**
     * Agregar notas adicionales a códigos propios
     * @param AgregarNotaAdicionalOrdenCodigosPropiosRequest $request
     * @return JsonResponse
     * @throws \Throwable
     * @author Thomas
     */
    public function agregarNotaAdicionalOrdenCodigosPropios(AgregarNotaAdicionalOrdenCodigosPropiosRequest $request): JsonResponse
    {
        try {
            $response = $this->ordenamientoService->agregarNotaAdicionalOrdenCodigosPropios($request->validated());
            return response()->json($response, Response::HTTP_OK);
        } catch (\Throwable $th) {
            return response()->json(['error' => $th->getMessage()], 500);
        }
    }

    /**
     * Lista las notas adicionales de un códigos propio
     * @param int $ordenCodigoPropioId
     * @return JsonResponse
     * @throws \Throwable
     * @author Thomas
     */
    public function listarNotasAdicionalesOrdenCodigoPropio(int $ordenCodigoPropioId): JsonResponse
    {
        try {
            $notas = $this->ordenCodigoPropioRepository->listarNotasAdicionalesOrdenCodigoPropio($ordenCodigoPropioId);
            return response()->json($notas, Response::HTTP_OK);
        } catch (\Throwable $th) {
            return response()->json(['Error' => $th->getMessage()], 500);
        }
    }

    /**
     * Lista los articulos de una orden pendientes de auditoria
     * @param int $ordenId
     * @return JsonResponse
     * @throws Throwable
     * @author Thomas
     */
    public function listarArticulosPorAuditar(int $ordenId): JsonResponse
    {
        try {
            $articulos = $this->ordenArticuloRepository->listarArticulosPorAuditar($ordenId);
            return response()->json($articulos, Response::HTTP_OK);
        } catch (\Throwable $th) {
            return response()->json([
                'error' => $th->getMessage(),
                'mensaje' => 'Error al consultar las ordenes',
            ], Response::HTTP_BAD_REQUEST);
        }
    }

    /**
     * Cambiar el direccionamiento de medicamentos
     * @param CambiarDireccionamientoMedicamentosRequest $request
     * @return JsonResponse
     * @throws \Throwable
     * @author Thomas
     */
    public function cambiarDireccionamientoMedicamentos(CambiarDireccionamientoMedicamentosRequest $request): JsonResponse
    {
        try {
            $response = $this->ordenamientoService->cambiarDireccionamientoMedicamentos($request->validated());
            return response()->json($response, Response::HTTP_OK);
        } catch (\Throwable $th) {
            return response()->json(['Error' => $th->getMessage()], 500);
        }
    }

    /**
     * Cambiar un CUP de una orden
     * @param int $ordenId
     * @param CambiarServicioOrdenRequest $request
     * @return JsonResponse
     * @throws \Throwable
     * @author Thomas
     */
    public function cambiarServicioOrden(int $ordenId, CambiarServicioOrdenRequest $request): JsonResponse
    {
        try {
            $response = $this->ordenamientoService->cambiarServicioOrden($ordenId, $request->validated());
            return response()->json($response, Response::HTTP_OK);
        } catch (\Throwable $th) {
            return response()->json(['error' => $th->getMessage()], 500);
        }
    }

    /**
     * Cambiar el Código Propio de una orden
     * @param int $ordenId
     * @param CambiarCodigoPropioOrdenRequest $request
     * @return JsonResponse
     * @throws \Throwable
     * @author Thomas
     */
    public function cambiarCodigoPropioOrden(int $ordenId, CambiarCodigoPropioOrdenRequest $request): JsonResponse
    {
        try {
            $response = $this->ordenamientoService->cambiarCodigoPropioOrden($ordenId, $request->validated());
            return response()->json($response, Response::HTTP_OK);
        } catch (\Throwable $th) {
            return response()->json(['error' => $th->getMessage()], 500);
        }
    }

    /**
     * Listar los servicios pendientes de facturar de un afiliado
     *
     * @param  mixed $afiliadoId
     * @return void
     */
    public function listarServiciosPendientesFacturar(Request $request)
    {
        try {
            $afiliadoId = $this->afiliadoRepository->consultarAfiliadoDocumento($request->input('documento'));
            $servicios = $this->ordenamientoService->listarServiciosPendientesFacturar(intval($afiliadoId->id));
            return response()->json($servicios, Response::HTTP_OK);
        } catch (\Throwable $th) {
            return response()->json([
                'error' => $th->getMessage(),
                'mensaje' => 'Error al consultar los servicios pendientes de facturar',
            ], Response::HTTP_BAD_REQUEST);
        }
    }

    /**
     * Listar los detalles de una orden usada
     * @param int $ordenProcedimientoId
     * @return JsonResponse
     * @throws \Throwable
     * @author Thomas
     */
    public function listarDetallesOrdenUsada(int $ordenProcedimientoId): JsonResponse
    {
        try {
            $response = $this->ordenProcedimientoRepository->listarDetallesOrdenUsada($ordenProcedimientoId);
            return response()->json($response, Response::HTTP_OK);
        } catch (\Throwable $th) {
            return response()->json(['error' => $th->getMessage()], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    public function listarOrdenesPorAfiliadoParaCitas(Request $request)
    {
        try {
            $ordenes = $this->ordenamientoService->validarOrdenYCita($request->all());
            return response()->json($ordenes);
        } catch (\Throwable $th) {
            return response()->json(['error' => $th->getMessage()], 400);
        }
    }

    /**
     * genera un consolidados de ordenes dispensadas junto con sus comprobantes y formulas
     * @param Request $request
     * @return Response
     * @throws \Exception
     * @author David Peláez
     */
    public function generarConsolidado(ConsolidadoFormulasRequest $request)
    {
        set_time_limit(-1);

        try {
            $fecha = $request->input('fecha', null);
            $formulas = (new FastExcel())->import($request->file('file'), function ($line) {
                $line['formula'] = intval($line['formula']);
                return $line;
            })
                ->unique('formula')
                ->pluck('formula');
            $authUser = Auth::user();
            # carpeta donde se guardará todo el consolidado
            $carpetaStorage = 'tmp/' . uniqid($fecha . '_consolidado_');
            # creamos la carpeta en storage, carpeta siempre unica
            mkdir(storage_path('app/' . $carpetaStorage), 0777, true);
            # tambien creamos el archivo de errores
            touch(storage_path('app/' . $carpetaStorage . '/errores.txt'));
            # separo las ordenes por chunks y luego las uno
            $ordenes = $formulas->chunk(500)->map(function ($chunk) use ($fecha) {
                return $this->ordenamientoRepository->listarOrdenesPorFechaUltimoMovimiento($fecha, $chunk->toArray(), true);
            })->flatten();

            $jobs = [];
            foreach ($ordenes as $orden) {
                $jobs[] = new ConsolidadoFormula($orden, $carpetaStorage, $fecha);
            }

            # creamos el registro del consolidado en la base de datos
            // $logData = [
            //     'nombre' => 'Consolidado de formulas ' . $fecha,
            //     'cantidad' => 'Consolidado de formulas del dia ' . $fecha . ' creado por ' . $authUser->email,
            //     'estado' => '',
            // ];
            // $this->logConsolidadoService->crear($logData);
            if (count($jobs) === 0) {
                # eliminamos la carpeta temporal
                $this->deleteFolder(storage_path('app/' . $carpetaStorage));
                return response()->json([
                    'mensaje' => 'No se encontraron ordenes para el consolidado de fórmulas en la fecha ' . $fecha,
                    'fecha' => $fecha,
                ], Response::HTTP_OK);
            }

            Bus::batch($jobs)->then(function (Batch $batch) use ($carpetaStorage, $authUser, $fecha) {
                Bus::chain([
                    new CombinarConsolidadoFormulas($carpetaStorage),
                    new ComprimirCarpeta($carpetaStorage),
                    // new SubirArchivo($carpetaStorage, 'paquetes/formulas/'),
                    // new FinalizarConsolidadoFormulas($carpetaStorage, 'paquetes/formulas/', $authUser->email, $fecha)
                ])->catch(function (Throwable $e) use ($authUser, $carpetaStorage, $fecha) {
                    # funcion para eliminar carpetas
                    $deleteFolder = function ($folderPath) use (&$deleteFolder) {
                        foreach (glob($folderPath . '/*') as $file) {
                            is_dir($file) ? $deleteFolder($file) : unlink($file);
                        }
                        rmdir($folderPath);
                    };
                    # eliminamos la carpeta temporal
                    $folderPath = storage_path('app/' . $carpetaStorage);
                    if (is_dir($folderPath)) {
                        $deleteFolder($folderPath);
                    }
                    # eliminamos el zip
                    $zipPath = storage_path('app/' . $carpetaStorage . '.zip');
                    if (file_exists($zipPath)) {
                        unlink($zipPath);
                    }
                    Log::channel('consolidados')->error('Error al generar el consolidado de fórmulas: ' . $e->getMessage());
                    Mail::to($authUser->email)->send(new ZipFormulasError($fecha));
                })
                    ->onQueue('pesado')
                    ->dispatch();
            })->catch(function (Batch $batch, Throwable $e) use ($authUser, $fecha) {
                Log::channel('consolidados')->error('Error al generar la estructura: ' . $e->getMessage());
                Mail::to($authUser->email)->send(new ZipFormulasError($fecha));
            })
                ->name('Consolidado de Fórmulas')
                ->dispatch();

            return response()->json([
                'mensaje' => 'Consolidado de fórmulas en proceso, se enviará un correo con el enlace de descarga una vez finalizado.',
                'fecha' => $fecha,
            ], Response::HTTP_OK);
        } catch (\Throwable $th) {
            return response()->json([
                'error' => $th->getMessage(),
                'mensaje' => 'Error al generar el consolidado de fórmulas',
            ], Response::HTTP_BAD_REQUEST);
        }
    }

     /**
     * lista las ordenes segun el cup deseado
     * @param afiliado_id 
     * @param cup_id
     * @return Response
     */
    public function listarOrdenesCups($afiliado_id, $cup_id)
    {
        try {
            $ordenCups = $this->ordenProcedimientoRepository->listarOrdenesCups($afiliado_id, $cup_id);
            return response()->json($ordenCups);
        } catch (\Throwable $th) {
            return response()->json([
                'error' => $th->getMessage(),
                'mensaje' => 'Error al consultar las ordenes por cups',
            ], Response::HTTP_BAD_REQUEST);
        }
    }
}
