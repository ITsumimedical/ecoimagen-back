<?php

namespace App\Http\Modules\Historia\ResultadoLaboratorio\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Http\Controllers\Controller;
use App\Http\Modules\Historia\ResultadoLaboratorio\Repositories\ResultadoLaboratorioRepository;
use App\Http\Modules\Historia\ResultadoLaboratorio\Request\CrearResultadoLaboratorioRequest;
use App\Http\Modules\Historia\ResultadoLaboratorio\Services\ResultadoLaboratorioService;

class ResultadoLaboratorioController extends Controller
{
    public function __construct(
        protected ResultadoLaboratorioRepository $resultadoLaboratorioRepository,
        protected ResultadoLaboratorioService $resultadoLaboratorioService
    ) {}

    public function guardar(CrearResultadoLaboratorioRequest $request)
    {
        try {
            $antecedentes =   $this->resultadoLaboratorioService->guardarResultado($request->all());
            return response()->json([
                'mensaje' => $antecedentes
            ], Response::HTTP_CREATED);
        } catch (\Throwable $th) {
            return response()->json([
                'error' => $th->getMessage()
            ], Response::HTTP_BAD_REQUEST);
        }
    }

    public function listarResultado(Request $request)
    {
        try {
            $antecedentes =  $this->resultadoLaboratorioRepository->listarResultado($request);
            return response()->json($antecedentes);
        } catch (\Throwable $th) {
            return response()->json([
                'mensaje' => 'error al consultar los antecedentes ecomapa'
            ], Response::HTTP_BAD_REQUEST);
        }
    }

    public function eliminarResultado($id)
    {
        try {
            $this->resultadoLaboratorioService->eliminarLaboratorio($id);
            return response()->json('Eliminado con éxito', Response::HTTP_OK);
        } catch (\Throwable $th) {
            return response()->json(['Error al eliminar', $th->getMessage()], Response::HTTP_BAD_REQUEST);
        }
    }

    public function listarResultadoRiesgoCardiosvacular(Request $request)
    {
        try {
            $antecedentes =  $this->resultadoLaboratorioRepository->listarResultadoRiesgoCardiovascular($request);
            return response()->json($antecedentes);
        } catch (\Throwable $th) {
            return response()->json([
                'mensaje' => 'error al consultar los resultados de riesgo cardiovascular'
            ], Response::HTTP_BAD_REQUEST);
        }
    }

    public function guardarMejora(Request $request)
    {
        try {
            $mejora =   $this->resultadoLaboratorioService->guardarMejora($request);
            return response()->json([
                'mensaje' => $mejora
            ], Response::HTTP_CREATED);
        } catch (\Throwable $th) {
            return response()->json([
                'error' => $th->getMessage()
            ], Response::HTTP_BAD_REQUEST);
        }
    }
}
