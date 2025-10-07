<?php

namespace App\Http\Modules\Concurrencia\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Http\Controllers\Controller;
use App\Http\Modules\Concurrencia\Requests\CrearCostoEvitableRequest;
use App\Http\Modules\Concurrencia\Repositories\CostoEvitableRepository;

class CostoEvitableController extends Controller
{
    public function __construct(protected CostoEvitableRepository $costoEvitableRepository)
    {
    }

    public function guardarCosto(CrearCostoEvitableRequest $request) {
        try {
            $costo = $this->costoEvitableRepository->guardarCosto($request);
            return response()->json($costo, Response::HTTP_CREATED);
        } catch (\Throwable $th) {
            return response()->json([
                'mensaje' => 'Error al registrar el costo evitable',
                'error' => $th->getMessage()
            ], Response::HTTP_BAD_REQUEST);
        }
    }

    public function listarCosto(Request $request){
        try {
            $ingreso = $this->costoEvitableRepository->listarCosto($request);
            return response()->json($ingreso, 200);
        } catch (\Throwable $th) {
            return response()->json([
                'res' => false,
                'message' => 'Error al listar los costos',
                'error' => $th->getMessage()
            ], 400);
        }
    }

    public function eliminarCosto(Request $request)
    {
        try {
            $costo = $this->costoEvitableRepository->eliminarCosto($request);
            return response()->json($costo, Response::HTTP_OK);
        } catch (\Throwable $th) {
            return response()->json([
                'res' => false,
                'mensaje' => 'Error al eliminar los costos',
                'error' => $th->getMessage()
            ], Response::HTTP_BAD_REQUEST);
        }
    }
}
