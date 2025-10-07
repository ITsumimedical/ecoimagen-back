<?php

namespace App\Http\Modules\AfiliadoClasificaciones\Controller;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Http\JsonResponse;
use App\Http\Controllers\Controller;
use App\Http\Modules\AfiliadoClasificaciones\Services\AfiliadoClasificacionService;
use App\Http\Modules\AfiliadoClasificaciones\Request\CrearAfiliacionClasificacionRequest;
use App\Http\Modules\AfiliadoClasificaciones\Repositories\AfiliadoClasificacionRepository;
use App\Http\Modules\AfiliadoClasificaciones\Request\ActualizarAfiliadoClasificacionRequest;

class AfiliadoClasificacionController extends Controller
{
    private $afiliacionClasificacionRepository;
    protected $afiliacionClasificacionService;

    public function __construct(){
        $this->afiliacionClasificacionRepository = new AfiliadoClasificacionRepository();
        $this->afiliacionClasificacionService = new AfiliadoClasificacionService();
    }

    /**
     * lista las clasificaciones de un afiliado
     * @param Request $request
     * @return Response
     * @author kobatime
     */
    public function listar($afiliado_id)
    {
        try {
            $afiliacion = $this->afiliacionClasificacionRepository->listarAfiliacionClasificacion($afiliado_id);
            return response()->json($afiliacion, Response::HTTP_OK);
        } catch (\Throwable $th) {
            return response()->json([
                'mensaje' => 'Error al recuperar las afiliaciones del contrato',
            ], Response::HTTP_BAD_REQUEST);
        }
    }

    /**
     * Guarda una clasificacion de un afiliado
     * @param Request $request
     * @return Response
     * @author kobatime
     */
    public function crear(CrearAfiliacionClasificacionRequest $request):JsonResponse{
        try {
            $afiliacion = $this->afiliacionClasificacionRepository->crearClasificacion($request->validated());

            if(!$afiliacion){
                return response()->json(['mensaje' => 'El afiliado ya se encuentra con esta clasificación.'], 404);
            }
            return response()->json($afiliacion, Response::HTTP_CREATED);
        } catch (\Throwable $th) {
            return response()->json($th->getMessage(), Response::HTTP_BAD_REQUEST);
        }
    }

    /**
     * Actualiza una afiliacion de un empleado
     * @param Request $request
     * @return Response
     * @author leon
     */
    public function actualizarEstadoClasificacion(ActualizarAfiliadoClasificacionRequest $request, int $id ): JsonResponse {
        try {
            $estado = $request->boolean('estado');

            $this->afiliacionClasificacionService->actualizarEstado($id, $estado);

            return response()->json([
                'res' => true,
                'mensaje' => 'Estado actualizado correctamente',
            ]);
        } catch (\Throwable $e) {
            return response()->json([
                'res' => false,
                'mensaje' => 'Error al actualizar estado',
            ], JsonResponse::HTTP_BAD_REQUEST);
        }
    }

    /**
     * Proceso de eliminacion de clasificacion al afiliado
     *
     * @author Calvarez
     */
    function eliminarClasificacion(Request $request) {
        try {
            $this->afiliacionClasificacionService->eliminarClasificacionAfiliado($request);
            return response()->json([
                'mensaje' => 'Se elimino con exito'
            ], 200);
        } catch (\Throwable $th) {
            return response()->json([
                'error' => $th->getMessage(),
                'mensaje' => 'No fue posible eliminar la clasificación!'
            ], Response::HTTP_BAD_REQUEST);
        }
    }

}
