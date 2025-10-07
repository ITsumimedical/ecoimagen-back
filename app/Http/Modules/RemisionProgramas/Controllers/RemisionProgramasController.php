<?php

namespace App\Http\Modules\RemisionProgramas\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Modules\RemisionProgramas\Repositories\RemisionProgramasRepository;
use App\Http\Modules\RemisionProgramas\Request\CrearRemisionProgramaRequest;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class RemisionProgramasController extends Controller
{
    public function __construct(
        private RemisionProgramasRepository $remisionRepository,
    ) {}

    public function crearRemision(CrearRemisionProgramaRequest $request)
    {
        try {
            $remision = $this->remisionRepository->crear($request->validated());
            return response()->json($remision, Response::HTTP_OK);
        } catch (\Throwable $th) {
            return response()->json('error', $th->getMessage());
        }
    }

    public function listarPorAfiliado(Request $request)
    {
        try {
            $remision = $this->remisionRepository->listarPorAfiliado($request->all());
            return response()->json($remision, Response::HTTP_OK);
        } catch (\Throwable $th) {
            return response()->json([
                'error' => $th->getMessage(),
                'mensaje' => 'Ha ocurrido un Error al traer las Remisiones del Afiliado'
            ], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    public function eliminarRemision($id)
    {
        try {
            $remision = $this->remisionRepository->eliminarRemision($id);
            return response()->json($remision, Response::HTTP_OK);
        } catch (\Throwable $th) {
            return response()->json([
                'Error' => $th->getMessage(),
                'Mensaje' => "Ha ocurrido un Error al Eliminar"
            ], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }
}
