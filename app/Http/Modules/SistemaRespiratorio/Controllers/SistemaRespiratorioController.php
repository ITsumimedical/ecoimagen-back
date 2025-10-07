<?php

namespace App\Http\Modules\SistemaRespiratorio\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Modules\SistemaRespiratorio\Repositories\SistemaRespiratoriaRepository;
use App\Http\Modules\SistemaRespiratorio\Repositories\SistemaRespiratorioRepository;
use App\Http\Modules\SistemaRespiratorio\Services\SistemaRespiratorioService;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class SistemaRespiratorioController extends Controller
{
    public function __construct(private SistemaRespiratorioService $sistemaRespiratorioService, private SistemaRespiratorioRepository $sistemaRespiratorioRepository) {}

    public function crear(Request $request)
    {
        try {
            $sistemaRespiratorio = $this->sistemaRespiratorioService->crearSistemaRespiratorio($request->all());
            return response()->json($sistemaRespiratorio, Response::HTTP_CREATED);
        } catch (\Throwable $th) {
            return response()->json([
                'error' => $th->getMessage(),
                'mensaje' => 'Ha ocurrido un Error al Crear'
            ], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    public function obtenerDatos($afiliadoId)
    {
        try {
            $rqc = $this->sistemaRespiratorioRepository->obtenerDatosporAfiliado($afiliadoId);
            return response()->json($rqc);
        } catch (\Throwable $th) {
            return response()->json(['error' => $th->getMessage()], 400);
        }
    }
}
