<?php

namespace App\Http\Modules\Recomendaciones\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Http\JsonResponse;
use App\Http\Controllers\Controller;
use App\Http\Modules\Recomendaciones\Services\RecomendacionesService;
use App\Http\Modules\Recomendaciones\Requests\CrearRecomendacionesRequest;
use App\Http\Modules\Recomendaciones\Repositories\RecomendacionesRepository;
use App\Http\Modules\Recomendaciones\Requests\ActualizarRecomendacionesRequest;

class RecomendacionesController extends Controller
{
    public function __construct(
        private RecomendacionesRepository $recomendacionesRepository,
        private RecomendacionesService $recomendacionesService,
    ) {}

    /**
     * crear - crea una recomendación para un cup o un cie10
     *
     * @param  mixed $request
     * @return void
     */
    public function crear(CrearRecomendacionesRequest $request): JsonResponse
    {
        try {
            $recomendaciones = $this->recomendacionesService->crearRecomendacion($request->validated());
            return response()->json($recomendaciones, Response::HTTP_CREATED);
        } catch (\Throwable $th) {
            return response()->json([
                'error' => 'Error al crear la(s) recomendación(es)',
                'detalle' => $th->getMessage()
            ], Response::HTTP_BAD_REQUEST);
        }
    }

    /**
     * listar - lista las recomendaciones
     *
     * @param  mixed $request
     * @return void
     */
    public function listar(Request $request)
    {
        try {
            $recomendaciones = $this->recomendacionesRepository->listarRecomendaciones($request);
            return response()->json($recomendaciones);
        } catch (\Throwable $th) {
            return response()->json($th->getMessage());
        }
    }

    public function listarCondicionado(Request $request)
    {
        try {
            $recomendaciones = $this->recomendacionesRepository->listarCondicionado($request);
            return response()->json($recomendaciones);
        } catch (\Throwable $th) {
            return response()->json($th->getMessage());
        }
    }

    /**
     * actualizar - actualiza una recomendación según su id
     *
     * @param  mixed $request
     * @param  mixed $id
     * @return void
     */
    public function actualizar(ActualizarRecomendacionesRequest $request, int $id): JsonResponse
    {
        try {
            $datos = $request->validated();

            $recomendacion = $this->recomendacionesRepository->buscar($id);

            $recomendacion->cie10_id = $datos['cie10_id'];
            unset($datos['cie10_id']);

            $this->recomendacionesRepository->actualizar($recomendacion, $datos);

            return response()->json(
                $recomendacion->fresh(['cie10']),
                Response::HTTP_OK
            );
        } catch (\Throwable $th) {
            return response()->json([
                'error' => 'Error al actualizar la recomendación',
                'detalle' => $th->getMessage(),
            ], Response::HTTP_BAD_REQUEST);
        }
    }

    /**
     * cambiarEstado - cambia el estado de una recomendación según su id
     *
     * @param  mixed $id
     * @return void
     */
    public function cambiarEstado($id)
    {
        try {
            $recomendacion = $this->recomendacionesService->cambiarEstado($id);
            return response()->json($recomendacion, Response::HTTP_ACCEPTED);
        } catch (\Throwable $th) {
            return response()->json([
                'res' => false,
                'message' => 'Error al cambiar el estado!',
                'error' => $th->getMessage()
            ], Response::HTTP_BAD_REQUEST);
        }
    }
}
