<?php

namespace App\Http\Modules\ImagenesContratoSedes\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Modules\ImagenesContratoSedes\Services\ImagenesContratoSedesService;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class ImagenesContratoSedesController extends Controller
{
    public function __construct(protected ImagenesContratoSedesService $imagenesContratoSedesService) {}

    public function ImagenesContratoSedesController(Request $request)
    {
        try {
            $imagen = $this->imagenesContratoSedesService->subirImagen($request->all());
            return response()->json($imagen, Response::HTTP_CREATED);
        } catch (\Throwable $th) {
            return response()->json([
                'error' => $th->getMessage(),
                'mensaje' => 'Ha ocurrido un Error al Crear'
            ], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }
}
