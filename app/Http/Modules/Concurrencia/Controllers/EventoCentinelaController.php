<?php

namespace App\Http\Modules\Concurrencia\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Http\Controllers\Controller;
use App\Http\Modules\Concurrencia\Requests\CrearEventoCentinelaRequest;
use App\Http\Modules\Concurrencia\Repositories\EventoCentinelaRepository;

class EventoCentinelaController extends Controller
{
    public function __construct(protected EventoCentinelaRepository $eventoRepository)
    {
    }

    public function guardarEvento(CrearEventoCentinelaRequest $request) {
        try {
            $evento = $this->eventoRepository->guardarEvento($request);
            return response()->json($evento, Response::HTTP_CREATED);
        } catch (\Throwable $th) {
            return response()->json([
                'mensaje' => 'Error al registrar el evento centinela',
                'error' => $th->getMessage()
            ], Response::HTTP_BAD_REQUEST);
        }
    }

    public function listarEvento(Request $request){
        try {
            $ingreso = $this->eventoRepository->listarEvento($request);
            return response()->json($ingreso, 200);
        } catch (\Throwable $th) {
            return response()->json([
                'res' => false,
                'message' => 'Error al listar los eventos',
                'error' => $th->getMessage()
            ], 400);
        }
    }

    public function eliminarEvento(Request $request)
    {
        try {
            $evento = $this->eventoRepository->eliminarEvento($request);
            return response()->json($evento, Response::HTTP_OK);
        } catch (\Throwable $th) {
            return response()->json([
                'res' => false,
                'mensaje' => 'Error al eliminar los eventos',
                'error' => $th->getMessage()
            ], Response::HTTP_BAD_REQUEST);
        }
    }
}
