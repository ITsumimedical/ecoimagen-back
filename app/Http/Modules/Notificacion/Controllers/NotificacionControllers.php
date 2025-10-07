<?php

namespace App\Http\Modules\Notificacion\Controllers;

use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Modules\Notificacion\Services\NotificacionService;
use Illuminate\Http\Response;

class NotificacionControllers extends Controller
{

    public function __construct(protected NotificacionService $notificacionService)
    {
    }

    /**
     * Consulta las notificaciones del usuario autenticado.
     * @param Request $request
     * @return JsonResponse
     * @author Kobatime
     * @modifiedBy jose vas
     */
    public function listar(Request $request): JsonResponse
    {
        try {
            $notificaciones = $this->notificacionService->listarNotificaciones($request->user()->id);
            return response()->json($notificaciones, Response::HTTP_OK);
        } catch (\Throwable $th) {
            return response()->json([
                $th->getMessage(),
                'mensaje' => 'Ha ocurrido un error al buscar las notificaciones'
            ], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    /**
     * Elimina una notificación por id de usuario y redis_id
     * @param int $usuarioId 
     * @param string $redisId
     * @return JsonResponse
     * @author Kobatime
     * @modifiedBy jose vasquez 
     */
    public function eliminarNotificacion(int $usuarioId, string $redisId): JsonResponse
    {
        try {
            $estadoNotificacion = $this->notificacionService->eliminarEnRedisYBD($usuarioId, $redisId);
            return response()->json($estadoNotificacion, Response::HTTP_OK);
        } catch (\Throwable $th) {
            return response()->json([
                'mensaje' => 'ha ocurrido un error al cambiar la notificacion como leida'
            ], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }
}
