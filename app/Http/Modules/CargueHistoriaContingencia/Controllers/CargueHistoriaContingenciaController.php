<?php

namespace App\Http\Modules\CargueHistoriaContingencia\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Http\Controllers\Controller;
use App\Http\Modules\CargueHistoriaContingencia\Services\CargueHistoriaContingenciaService;

class CargueHistoriaContingenciaController extends Controller
{
    public function __construct(protected CargueHistoriaContingenciaService $cargueHistoriaContingenciatService) {
    }

    public function crear(Request $request)
    {
        try {
            $asignacionCitaAfiliado = $this->cargueHistoriaContingenciatService->guardar($request);
            return response()->json($asignacionCitaAfiliado, 200);
        } catch (\Throwable $th) {
            return response()->json([
                'res' => false,
                'error' => $th->getMessage(),
                'mensaje' => 'Error al asignar cita al afiliado!.',
            ], Response::HTTP_BAD_REQUEST);
        }
    }
}
