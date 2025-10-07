<?php

namespace App\Http\Modules\UnidadesMedidasDispensacion\Controller;

use App\Http\Controllers\Controller;
use App\Http\Modules\UnidadesMedidasDispensacion\Repositories\UnidadesMedidasDispensacionRepository;
use App\Http\Modules\UnidadesMedidasDispensacion\Request\ActualizarUnidadesMedidasDispensacionRequest;
use App\Http\Modules\UnidadesMedidasDispensacion\Request\CrearUnidadesMedidasDispensacionRequest;
use App\Http\Modules\UnidadesMedidasDispensacion\Services\UnidadesMedidasDispensacionService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class UnidadesMedidasDispensacionController extends Controller
{
    public function __construct(
        protected UnidadesMedidasDispensacionRepository $unidadesMedicamentosRepository,
        protected UnidadesMedidasDispensacionService $unidadesMedidasDispensacionService
    ) {}

    public function crear(CrearUnidadesMedidasDispensacionRequest $request)
    {
        try {
            $unidades = $this->unidadesMedicamentosRepository->crear($request->validated());
            return response()->json($unidades);
        } catch (\Throwable $th) {
            return response()->json(['error' => $th->getMessage()], 400);
        }
    }

    public function listar(Request $request)
    {
        try {
            $medidas = $this->unidadesMedicamentosRepository->listar($request);
            return response()->json($medidas);
        } catch (\Throwable $th) {
            return response()->json(['error' => $th->getMessage()], 400);
        }
    }

    public function actualizar($id, ActualizarUnidadesMedidasDispensacionRequest $request)
    {
        try {
            $unidades = $this->unidadesMedidasDispensacionService->actualizar($id, $request->validated());
            return response()->json($unidades);
        } catch (\Throwable $th) {
            return response()->json(['error' => $th->getMessage()], 400);
        }
    }

    public function eliminar($id)
    {
        try {
            $unidades = $this->unidadesMedicamentosRepository->eliminar($id);
            return response()->json($unidades);
        } catch (\Throwable $th) {
            return response()->json(['error' => $th->getMessage()], 400);
        }
    }

    public function listarSinPaginar(Request $request): JsonResponse
    {
        try {
            $medidas = $this->unidadesMedicamentosRepository->listarMedidas($request->all());
            return response()->json($medidas, Response::HTTP_OK);
        } catch (\Throwable $th) {
            return response()->json([
                'mensaje' => 'Ha ocurrido un error al listar'
            ], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }
}
