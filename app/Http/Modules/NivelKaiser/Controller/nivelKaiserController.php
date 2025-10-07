<?php

namespace App\Http\Modules\NivelKaiser\Controller;

use App\Http\Controllers\Controller;
use App\Http\Modules\NivelKaiser\Repositories\nivelKaiserRepository;
use App\Http\Modules\NivelKaiser\Request\CrearNivelKaiserRequest;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class nivelKaiserController extends Controller
{
    public function __construct(protected nivelKaiserRepository $nivelKaiserRepository) {
    }

    public function crear(CrearNivelKaiserRequest $request)
    {
        try {
            $nivelKaiser = $this->nivelKaiserRepository->crearKaiser($request->validated());
            return response()->json(['message' => 'Creado o actualizado con éxito', 'data' => $nivelKaiser], Response::HTTP_OK);
        } catch (\Throwable $th) {
            return response()->json(['error' => $th->getMessage()], Response::HTTP_BAD_REQUEST);
        }
    }

    public function obtenerDatos($afiliadoId)
    {
        try {
            $nivelKaiser = $this->nivelKaiserRepository->obtenerDatosporAfiliado($afiliadoId);
            return response()->json($nivelKaiser, Response::HTTP_OK);
        } catch (\Throwable $th) {
            return response()->json(['error' => $th->getMessage()], Response::HTTP_BAD_REQUEST);
        }
    }
}
