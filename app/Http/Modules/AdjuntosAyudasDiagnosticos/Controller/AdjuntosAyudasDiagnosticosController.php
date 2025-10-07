<?php

namespace App\Http\Modules\AdjuntosAyudasDiagnosticos\Controller;

use App\Http\Controllers\Controller;
use App\Http\Modules\AdjuntosAyudasDiagnosticos\Requests\CrearAdjuntosAyudasDiagnosticosRequest;
use App\Http\Modules\AdjuntosAyudasDiagnosticos\Repositories\AdjuntosAyudasDiagnosticosRespository;
use App\Http\Modules\AdjuntosAyudasDiagnosticos\Services\AdjuntosAyudasDiagnosticosService;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class AdjuntosAyudasDiagnosticosController extends Controller
{
    public function __construct(protected AdjuntosAyudasDiagnosticosService $adjuntosAyudasDiagnosticosService, protected AdjuntosAyudasDiagnosticosRespository $adjuntosAyudasDiagnosticosRespository) {}

    public function crear(CrearAdjuntosAyudasDiagnosticosRequest $request)
    {
        try {
            $adjunto = $this->adjuntosAyudasDiagnosticosService->crearAdjunto($request->validated());
            return response()->json($adjunto, Response::HTTP_CREATED);
        } catch (\Throwable $th) {
            return response()->json([
                'Error' => $th->getMessage(),
                'mensaje' => 'Ha ocurrido un Error al Crear'
            ], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    public function verAdjuntos(Request $request)
    {
        try {
            $consultarAdjuntos = $this->adjuntosAyudasDiagnosticosRespository->buscarAdjuntos($request->all());
            return response()->json($consultarAdjuntos, Response::HTTP_OK);
        } catch (\Throwable $th) {
            return response()->json([
                'error' => $th->getMessage(),
                'mensaje' => 'Error al consultar los adjuntos de Ayudas Diagnosticas'
            ], Response::HTTP_BAD_REQUEST);
        }
    }
}
