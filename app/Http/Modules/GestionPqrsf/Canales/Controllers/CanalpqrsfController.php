<?php

namespace App\Http\Modules\GestionPqrsf\Canales\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Http\JsonResponse;
use App\Http\Controllers\Controller;
use App\Http\Modules\GestionPqrsf\Canales\Models\Canalpqrsf;
use App\Http\Modules\GestionPqrsf\Canales\Repositories\CanalpqrsfRepository;
use App\Http\Modules\GestionPqrsf\Canales\Requests\ActualizarCanalpqrsfRequest;
use App\Http\Modules\GestionPqrsf\Canales\Requests\CrearCanalpqrsfRequest;

class CanalpqrsfController extends Controller
{
    private $canalPqrsfRepository;

    public function __construct(){
        $this->canalPqrsfRepository = new CanalpqrsfRepository;
    }

    /**
     * lista los canales de pqrsf
     * @param Request $request
     * @return Response
     * @author leon
     */
    public function listar(Request $request): JsonResponse
    {
        $canal = $this->canalPqrsfRepository->listarCanal($request);
        try {
            return response()->json($canal, Response::HTTP_OK);
        } catch (\Throwable $th) {
            return response()->json([
                'res' => false,
                'mensaje' => 'Error al listar los canales de PQRSF',
            ], Response::HTTP_BAD_REQUEST);
        }
    }
    public function listarTodos(Request $request): JsonResponse
    {
        $canal = $this->canalPqrsfRepository->listarTodos($request);
        try {
            return response()->json($canal, Response::HTTP_OK);
        } catch (\Throwable $th) {
            return response()->json([
                'res' => false,
                'mensaje' => 'Error al listar los canales de PQRSF',
            ], Response::HTTP_BAD_REQUEST);
        }
    }

    /**
     * Guarda un canal de pqrsf
     * @param Request $request
     * @return Response
     * @author leon
     */
    public function crear(CrearCanalpqrsfRequest $request):JsonResponse{
        try {
            $canal = $this->canalPqrsfRepository->crear($request->validated());
            return response()->json($canal, Response::HTTP_CREATED);
        } catch (\Throwable $th) {
            return response()->json($th->getMessage(), Response::HTTP_BAD_REQUEST);
        }
    }

    /**
     * Actualiza un canal de pqrsf
     * @param Request $request
     * @return Response
     * @author leon
     */
    public function actualizar(ActualizarCanalpqrsfRequest $request, Canalpqrsf $id){
        try {
            $this->canalPqrsfRepository->actualizar($id, $request->validated());
            return response()->json([]);
        } catch (\Throwable $th) {
            return response()->json($th->getMessage(),400);
        }
    }

    public function cambiarEstado($id): JsonResponse
    {
        try {
            $canal = $this->canalPqrsfRepository->CambiarEstado($id);
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
