<?php

namespace App\Http\Modules\BodegasReps\Controller;

use App\Http\Controllers\Controller;
use App\Http\Modules\BodegasReps\Repositories\BodegaRepRepository;
use App\Http\Modules\BodegasReps\Request\CrearBodegasRepsRequest;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class BodegasRepsController extends Controller
{
    public function __construct(protected BodegaRepRepository $bodegaRepRepository)
    {
    }

    /**
     * Añade reps a una bodega
     * @param CrearBodegasRepsRequest $request
     * @return JsonResponse
     * @throws \Exception
     * @author Thomas
     */
    public function añadirRepsABodega(CrearBodegasRepsRequest $request): JsonResponse
    {
        try {
            $response = $this->bodegaRepRepository->añadirRepsABodega($request->validated());
            return response()->json($response, 201);
        } catch (\Throwable $th) {
            return response()->json(['error' => $th->getMessage()], 500);
        }
    }

    public function listarRepsPorBodega(int $bodegaId)
    {
        $reps = $this->bodegaRepRepository->listarRepsPorBodega($bodegaId);

        if ($reps) {
            return response()->json($reps, 200);
        } else {
            return response()->json(['error' => 'No se encontraron reps para la bodega especificada'], 404);
        }
    }

    public function eliminarRepsBodega(Request $request)
    {
        $bodegaId = $request->input('bodega_id');
        $rep_id = $request->input('rep_id');

        if (is_null($bodegaId)) {
            return response()->json(['error' => 'El ID de la bodega es requerido'], 400);
        }

        try {
            $resultado = $this->bodegaRepRepository->eliminarRepsBodega($bodegaId, $rep_id);
            if ($resultado) {
                return response()->json(['message' => 'Reps eliminados correctamente'], 200);
            } else {
                return response()->json(['error' => 'No se pudo eliminar los reps de la bodega'], 400);
            }
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }
}
