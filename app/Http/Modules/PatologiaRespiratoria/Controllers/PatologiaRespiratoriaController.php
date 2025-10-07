<?php

namespace App\Http\Modules\PatologiaRespiratoria\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Modules\PatologiaRespiratoria\Repositories\PatologiaRespiratoriaRepository;
use App\Http\Modules\PatologiaRespiratoria\Requests\CrearPatologiaRespiratoriaRequest;
use App\Http\Modules\PatologiaRespiratoria\Services\PatologiaRespiratoriaService;
use App\Http\Modules\SistemaRespiratorio\Repositories\SistemaRespiratorioRepository;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class PatologiaRespiratoriaController extends Controller
{
    public function __construct(private PatologiaRespiratoriaService $patologiaRespiratoriaService, private PatologiaRespiratoriaRepository $patologiaRespiratoria)
    {}

    public function crear(Request $request)
    {
        try {
            $patologiaRespiratoria = $this->patologiaRespiratoriaService->CrearPatologiaRespiratoria($request->all());
            return response()->json($patologiaRespiratoria , Response::HTTP_CREATED);
        } catch (\Throwable $th) {
            return Response()->json([
                'error' => $th->getMessage(),
                'mensaje' => 'Ha ocurrido un error al Crear la Patologia Respiratoria'
            ], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    public function obtenerDatos($afiliadoId)
    {
        try {
            $rqc = $this->patologiaRespiratoria->obtenerDatosporAfiliado($afiliadoId);
            return response()->json($rqc);
        } catch (\Throwable $th) {
            return response()->json(['error' => $th->getMessage()], 400);
        }
    }


}
