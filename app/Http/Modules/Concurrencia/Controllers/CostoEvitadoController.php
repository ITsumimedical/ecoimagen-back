<?php

namespace App\Http\Modules\Concurrencia\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Http\Controllers\Controller;
use App\Http\Modules\Concurrencia\Requests\CrearCostoEvitadoRequest;
use App\Http\Modules\Concurrencia\Repositories\CostoEvitadoRepository;

class CostoEvitadoController extends Controller
{
    public function __construct(protected CostoEvitadoRepository $costoEvitadoRepository)
    {
    }

    public function guardarCosto(CrearCostoEvitadoRequest $request) {
        try {
            $evento = $this->costoEvitadoRepository->guardarCosto($request);
            return response()->json($evento, Response::HTTP_CREATED);
        } catch (\Throwable $th) {
            return response()->json([
                'mensaje' => 'Error al registrar el costo evitado',
                'error' => $th->getMessage()
            ], Response::HTTP_BAD_REQUEST);
        }
    }

    public function listarCosto(Request $request){
        try {
            $ingreso = $this->costoEvitadoRepository->listarCosto($request);
            return response()->json($ingreso, 200);
        } catch (\Throwable $th) {
            return response()->json([
                'res' => false,
                'message' => 'Error al listar los eventos',
                'error' => $th->getMessage()
            ], 400);
        }
    }

    public function eliminarCosto(Request $request)
    {
        try {
            $costo = $this->costoEvitadoRepository->eliminarCosto($request);
            return response()->json($costo, Response::HTTP_OK);
        } catch (\Throwable $th) {
            return response()->json([
                'res' => false,
                'mensaje' => 'Error al eliminar los eventos',
                'error' => $th->getMessage()
            ], Response::HTTP_BAD_REQUEST);
        }
    }
}
