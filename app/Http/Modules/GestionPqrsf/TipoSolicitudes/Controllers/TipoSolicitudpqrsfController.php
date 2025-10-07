<?php

namespace App\Http\Modules\GestionPqrsf\TipoSolicitudes\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Http\JsonResponse;
use App\Http\Controllers\Controller;
use App\Http\Modules\GestionPqrsf\TipoSolicitudes\Models\TipoSolicitudpqrsf;
use App\Http\Modules\GestionPqrsf\TipoSolicitudes\Repositories\TipoSolicitudpqrsfRepository;
use App\Http\Modules\GestionPqrsf\TipoSolicitudes\Requests\ActualizarTipoSolicitudpqrsfRequest;
use App\Http\Modules\GestionPqrsf\TipoSolicitudes\Requests\CrearTipoSolicitudpqrsfRequest;

class TipoSolicitudpqrsfController extends Controller
{
    private $tipoSolicitudPqrsfRepository;

    public function __construct(){
        $this->tipoSolicitudPqrsfRepository = new TipoSolicitudpqrsfRepository;
    }

    /**
     * lista los tipos de solicitud de pqrsf
     * @param Request $request
     * @return Response
     * @author leon
     */
    public function listar(Request $request): JsonResponse
    {
        $tipoSolicitud = $this->tipoSolicitudPqrsfRepository->listarTipoSolicitudes($request);
        try {
            return response()->json([
                'res' => true,
                'data' => $tipoSolicitud
            ], Response::HTTP_OK);
        } catch (\Throwable $th) {
            return response()->json([
                'res' => false,
                'mensaje' => 'Error al listar los tipos de solicitud de PQRSF',
            ], Response::HTTP_BAD_REQUEST);
        }
    }
    public function listarTodos(Request $request): JsonResponse
    {
        $tipoSolicitud = $this->tipoSolicitudPqrsfRepository->listarTodos($request);
        try {
            return response()->json([
                'res' => true,
                'data' => $tipoSolicitud
            ], Response::HTTP_OK);
        } catch (\Throwable $th) {
            return response()->json([
                'res' => false,
                'mensaje' => 'Error al listar los tipos de solicitud de PQRSF',
            ], Response::HTTP_BAD_REQUEST);
        }
    }

    /**
     * Guarda un tipo de solicitud de pqrsf
     * @param Request $request
     * @return Response
     * @author leon
     */
    public function crear(CrearTipoSolicitudpqrsfRequest $request):JsonResponse{
        try {
            $tipoSolicitud = $this->tipoSolicitudPqrsfRepository->crear($request->validated());
            return response()->json($tipoSolicitud, Response::HTTP_CREATED);
        } catch (\Throwable $th) {
            return response()->json($th->getMessage(), Response::HTTP_BAD_REQUEST);
        }
    }

    /**
     * Actualiza un tipo de solicitud de pqrsf
     * @param Request $request
     * @return Response
     * @author leon
     */
    public function actualizar(ActualizarTipoSolicitudpqrsfRequest $request, TipoSolicitudpqrsf $id){
        try {
            $this->tipoSolicitudPqrsfRepository->actualizar($id, $request->validated());
            return response()->json([]);
        } catch (\Throwable $th) {
            return response()->json($th->getMessage(),400);
        }
    }

    public function cambiarEstado($id): JsonResponse
    {
        try {
            $canal = $this->tipoSolicitudPqrsfRepository->CambiarEstado($id);
            if ($canal) {
                return response()->json($canal, Response::HTTP_OK);
            } else {
                return response()->json([
                    'res' => false,
                    'mensaje' => 'Canal no encontrado',
                ], Response::HTTP_NOT_FOUND);
            }
        } catch (\Throwable $th) {
            return response()->json([
                'res' => false,
                'mensaje' => 'Error al cambiar el estado del canal',
            ], Response::HTTP_BAD_REQUEST);
        }
    }
}
