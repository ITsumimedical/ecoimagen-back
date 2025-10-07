<?php

namespace App\Http\Modules\ConfiguracionReportes\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Http\JsonResponse;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use App\Http\Modules\Reportes\Request\CrearReporteRequest;
use App\Http\Modules\ConfiguracionReportes\Repositories\CampoReporteRepository;
use App\Http\Modules\ConfiguracionReportes\Repositories\ConfiguracionReporteRepository;
use App\Http\Modules\ConfiguracionReportes\Services\ParametrizacionReporteService;
use Illuminate\Support\Facades\DB;

class ConfiguracionReporteController extends Controller
{
    public function __construct(
        protected ConfiguracionReporteRepository $configuracionReporteRepository,
        protected CampoReporteRepository $campoReporteRepository,
        protected ParametrizacionReporteService $parametrizacionReporteService
    ) {}

    /**
     * Crear un nuevo reporte junto con sus campos
     ** Manuela
     * @param Request $request
     * @return JsonResponse
     */
    public function store(Request $request): JsonResponse
    {
        try {
            $dataReporte = $request->only(['nombre', 'url', 'funcion_sql', 'permiso']);
            $dataReporte['created_by'] = Auth::id();
            $campos = $request->get('campos', []);

            $reporte = $this->configuracionReporteRepository->crear($dataReporte);

            foreach ($campos as $campo) {
                $campo['configuracion_reporte_id'] = $reporte->id;
                $this->campoReporteRepository->crear($campo);
            }

            return response()->json(['message' => 'Reporte y campos guardados exitosamente'], Response::HTTP_CREATED);
        } catch (\Throwable $th) {
            return response()->json([
                'error' => $th->getMessage(),
                'mensaje' => 'Error al guardar el reporte y sus campos.'
            ], Response::HTTP_BAD_REQUEST);
        }
    }

    /**
     * Listar todos los reportes
     ** Manuela
     * @return JsonResponse
     */
    public function index(): JsonResponse
    {
        try {
            $reportes = $this->configuracionReporteRepository->obtenerTodos(['id', 'nombre', 'url']);
            return response()->json(['data' => $reportes], Response::HTTP_OK);
        } catch (\Throwable $th) {
            return response()->json([
                'error' => $th->getMessage(),
                'mensaje' => 'Error al listar los reportes.'
            ], Response::HTTP_BAD_REQUEST);
        }
    }

    /**
     * Listar los campos de un reporte
     ** Manuela
     * @param int $id
     * @return JsonResponse
     */
    public function listarCampos(int $id): JsonResponse
    {
        try {
            $campos = $this->campoReporteRepository->buscarPor(['configuracion_reporte_id' => $id]);
            return response()->json(['campos' => $campos], Response::HTTP_OK);
        } catch (\Throwable $th) {
            return response()->json([
                'error' => $th->getMessage(),
                'mensaje' => 'Error al listar los campos del reporte.'
            ], Response::HTTP_BAD_REQUEST);
        }
    }

    /**
     * Obtener todos los reportes con sus campos asociados
     ** Manuela
     * @return JsonResponse
     */
    public function obtenerReportesConCampos(): JsonResponse
    {
        try {
            $reportes = $this->configuracionReporteRepository->obtenerTodos(['id', 'nombre', 'url', 'funcion_sql', 'permiso']);

            foreach ($reportes as &$reporte) {
                $campos = $this->campoReporteRepository->buscarPor(['configuracion_reporte_id' => $reporte->id]);
                $reporte->campos = $campos;
            }

            return response()->json(['data' => $reportes], Response::HTTP_OK);
        } catch (\Throwable $th) {
            return response()->json([
                'error' => $th->getMessage(),
                'mensaje' => 'Error al obtener los reportes con sus campos.'
            ], Response::HTTP_BAD_REQUEST);
        }
    }

    /**
     * Listar datos quemados de instituciones
     * Manuela
     * @return JsonResponse
     */
    public function listarReps(): JsonResponse
    {
        try {
            $instituciones = $this->configuracionReporteRepository->obtenerReps();
            return response()->json([$instituciones], Response::HTTP_OK);
        } catch (\Throwable $th) {
            return response()->json([
                'error' => $th->getMessage(),
                'mensaje' => 'Error al listar las instituciones.'
            ], Response::HTTP_BAD_REQUEST);
        }
    }

    /**
     * Listar entidades quemadas
     ** Manuela
     * @return JsonResponse
     */
    public function listarEntidades(): JsonResponse
    {
        try {
            $entidades = $this->configuracionReporteRepository->obtenerEntidades();
            return response()->json($entidades, 200);
        } catch (\Throwable $th) {
            return response()->json([
                'error' => $th->getMessage(),
                'mensaje' => 'Error al listar las entidades.'
            ], 400);
        }
    }

    /**
     * Registo de rutas (endpoint)
     *
     * @author Calvarez
     */
    public function registroRutas()
    {
        try {
            $rutas = $this->parametrizacionReporteService->registroRutas();
            return response()->json($rutas, Response::HTTP_CREATED);
        } catch (\Throwable $th) {
            return response()->json([
                'mensaje' => 'Error al registrar las rutas'
            ], Response::HTTP_BAD_REQUEST);
        }
    }

    /**
     * obtener de rutas (endpoint)
     *
     * @author Calvarez
     */
    public function listarRutas()
    {
        try {
            $rutas = $this->configuracionReporteRepository->rutas();
            return response()->json($rutas, Response::HTTP_CREATED);
        } catch (\Throwable $th) {
            return response()->json([
                'mensaje' => 'Error al registrar las rutas'
            ], Response::HTTP_BAD_REQUEST);
        }
    }

    /**
     * crear Reporte el cual alimenta la tabla de la cabecera como el detalle del reporte (parametros)
     *
     * @author Calvarez
     * CrearReporteRequest
     */
    public function crearReporte(CrearReporteRequest $request)
    {
        try {
            $reporte = $this->parametrizacionReporteService->crearReporte($request->validated());
            return response()->json($reporte, Response::HTTP_CREATED);
        } catch (\Throwable $th) {
            return response()->json([
                'mensaje' => 'Error al registar el reporte'
            ], Response::HTTP_BAD_REQUEST);
        }
    }

    /**
     * Obtener cabecera de reportes con sus detalles
     *
     * @author Calvarez
     */
    public function obtenerReportes() {
        try {
            $reportes = $this->configuracionReporteRepository->obtenerReportes();
            return response()->json($reportes, Response::HTTP_OK);
        } catch (\Throwable $th) {
            return response()->json([
                'mensaje' => 'Error al consultar los reportes'
            ], Response::HTTP_BAD_REQUEST);
        }
    }
}
