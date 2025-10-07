<?php

namespace App\Http\Modules\AreaSolicitudes\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Http\JsonResponse;
use App\Http\Controllers\Controller;
use App\Http\Modules\AreaSolicitudes\Services\AreaSolicitudesService;
use App\Http\Modules\AreaSolicitudes\Repositories\AreaSolicitudesRepository;

class AreaSolicitudesController extends Controller
{
    public function __construct(
        private AreaSolicitudesService $areaSolicitudesService,private AreaSolicitudesRepository $areaSolicitudesRepository
    ) {
    }

    public function listar(): JsonResponse
    {
        try {
            $area = $this->areaSolicitudesRepository->listarArea();
            return response()->json($area, Response::HTTP_CREATED);
        } catch (\Throwable $th) {
            return response()->json([
                'error' => $th->getMessage(),
                'mensaje' => 'Error al crear una categoria de mesa de ayudas'
            ], Response::HTTP_BAD_REQUEST);
        }
    }

    public function crear(Request $request): JsonResponse
    {
        try {
            $area = $this->areaSolicitudesService->guardar($request->all());
            return response()->json($area, Response::HTTP_CREATED);
        } catch (\Throwable $th) {
            return response()->json([
                'error' => $th->getMessage(),
                'mensaje' => 'Error al crear una categoria de mesa de ayudas'
            ], Response::HTTP_BAD_REQUEST);
        }
    }

    public function actualizar(Request $request, int $id)
    {


        try {
            $area = $this->areaSolicitudesRepository->buscar($id);
            $area->fill($request->except(["user_id"]));
            $responsableUpdate = $this->areaSolicitudesRepository->guardar($area);
            $area->user()->sync($request->user_id);
            return response()->json([
                'res' => true,
                'mensaje' => 'Actualizado con exito!.'
            ], Response::HTTP_OK);
        } catch (\Throwable $th) {
            return response()->json([
                'res' => false,
                'mensaje' => $th->getMessage(),
            ], Response::HTTP_BAD_REQUEST);
        }
    }
}
