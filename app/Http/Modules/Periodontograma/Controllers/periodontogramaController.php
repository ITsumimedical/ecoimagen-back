<?php

namespace App\Http\Modules\Periodontograma\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Modules\Periodontograma\Repositories\periodontogramaRepository;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class periodontogramaController extends Controller
{
    public function __construct(
        private periodontogramaRepository $periodontogramaRepository,
    ) {
    }

    public function crear(Request $request)
    {
        try {
            $this->periodontogramaRepository->crearOdontograma($request->all());
            return response()->json([
                'mensaje' => 'Periodontograma guardado con éxito'
            ]);
        } catch (\Throwable $th) {
            return response()->json(['error' => $th->getMessage()], 400);
        }
    }

    public function listarPeriodontogramas($consulta_id)
    {
        try {
            $periodontograma  =  $this->periodontogramaRepository->periodontogramaListar($consulta_id);
            return response()->json($periodontograma, Response::HTTP_OK);
        } catch (\Throwable $th) {
            return response()->json([
                'mensaje' => 'Error al registrar el periodontograma',
                'error' => $th->getMessage()
            ], Response::HTTP_BAD_REQUEST);
        }
    }

    public function actualizarPeriodontograma(Request $request, $id)
    {
        try {
            $this->periodontogramaRepository->actualizarPeriodontograma($id, $request->all());
            return response()->json([
                'mensaje' => 'Periodontograma actualizado con éxito'
            ]);
        } catch (\Throwable $th) {
            return response()->json(['error' => $th->getMessage()], 400);
        }
    }

    public function eliminarPeriodontograma($id)
    {
        try {
            $perio = $this->periodontogramaRepository->eliminarPeriodontograma($id);
            return response()->json($perio, Response::HTTP_OK);
        } catch (\Throwable $th) {
            return response()->json([
                'mensaje' => 'Error al eliminar el periodontograma',
                'error' => $th->getMessage()
            ], Response::HTTP_BAD_REQUEST);
        }
    }
}
