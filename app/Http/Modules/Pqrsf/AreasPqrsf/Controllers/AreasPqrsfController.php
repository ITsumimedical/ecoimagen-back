<?php

namespace App\Http\Modules\Pqrsf\AreasPqrsf\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Http\JsonResponse;
use App\Http\Controllers\Controller;
use App\Http\Modules\Pqrsf\AreasPqrsf\Request\CrearAreasPqrsfRequest;
use App\Http\Modules\Pqrsf\AreasPqrsf\Repositories\AreasPqrsfRepository;
use App\Http\Modules\Pqrsf\AreasPqrsf\Request\ActualizarAreasPqrsfRequest;
use App\Http\Modules\Pqrsf\AreasPqrsf\Services\AreasPqrsfService;

class AreasPqrsfController extends Controller
{
    private $areaRepository;

    public function __construct(private AreasPqrsfService $areasPqrsfService)
    {
        $this->areaRepository = new AreasPqrsfRepository();
    }


    public function listarAreas(Request $request)
    {
        try {
            $servicios = $this->areaRepository->listarAreas($request);
            return response()->json($servicios, Response::HTTP_OK);
        } catch (\Throwable $th) {
            return response()->json([
                'Mensaje' => $th->getMessage()
            ], Response::HTTP_BAD_REQUEST);
        }
    }

    public function crear(CrearAreasPqrsfRequest $request): JsonResponse
    {
        try {
            $area = $this->areasPqrsfService->crearServicio($request->validated());
            return response()->json($area, Response::HTTP_CREATED);
        } catch (\Throwable $th) {
            return response()->json($th->getMessage(), Response::HTTP_BAD_REQUEST);
        }
    }


    public function eliminar(Request $request)
    {
        try {
            $servicio = $this->areaRepository->eliminar($request);

            return response()->json($servicio, Response::HTTP_OK);
        } catch (\Throwable $th) {
            return response()->json([
                'res' => false,
                'mensaje' => 'Error al crear la medicamento de PQRSF!',
                'error' => $th->getMessage()
            ], Response::HTTP_BAD_REQUEST);
        }
    }

    public function actualizar(Request $request): JsonResponse
    {
        try {
            $area = $this->areaRepository->actualizarArea($request);

            return response()->json($area, Response::HTTP_OK);
        } catch (\Throwable $th) {
            return response()->json([
                'res' => false,
                'mensaje' => 'Error al crear la subcategoría de PQRSF!',
                'error' => $th->getMessage()
            ], Response::HTTP_BAD_REQUEST);
        }
    }

    /**
     * Actualiza las areas de un PQRSF
     * @param int $pqrsfId
     * @param ActualizarAreasPqrsfRequest $request
     * @return JsonResponse
     * @author Thomas
     */
    public function actualizarAreas($pqrsfId, ActualizarAreasPqrsfRequest $request): JsonResponse
    {
        try {
            $respuesta = $this->areaRepository->actualizarAreas($pqrsfId, $request);
            return response()->json($respuesta, Response::HTTP_OK);
        } catch (\Throwable $th) {
            return response()->json([
                'res' => false,
                'error' => $th->getMessage(),
            ], Response::HTTP_BAD_REQUEST);
        }
    }

    public function removerArea(int $pqrsfId, Request $request): JsonResponse
    {
        try {
            $respuesta = $this->areaRepository->removerArea($pqrsfId, $request->all());
            return response()->json($respuesta, Response::HTTP_OK);
        } catch (\Throwable $th) {
            return response()->json([
                'res' => false,
                'error' => $th->getMessage(),
            ], Response::HTTP_BAD_REQUEST);
        }
    }
}
