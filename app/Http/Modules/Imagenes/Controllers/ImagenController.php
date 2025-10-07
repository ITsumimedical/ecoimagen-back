<?php

namespace App\Http\Modules\Imagenes\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Modules\Imagenes\Services\ImagenService;
use Illuminate\Http\Request;

class ImagenController extends Controller
{
    public function __construct(private ImagenService $imagenService) {

    }

    public function crear(Request $request)
    {
        try {
            $this->imagenService->crearImagen($request);
            return response()->json([
                'mensaje' => 'Estadística creada con éxito'
            ]);
        } catch (\Throwable $th) {
            return response()->json(['error' => $th->getMessage()], 400);
        }
    }

    public function actualizar(Request $request)
    {
        try {
            $iamgen = $this->imagenService->actualizarImagen($request);
            return response()->json($iamgen,200);
        } catch (\Throwable $th) {
            return response()->json(['error' => $th->getMessage()], 400);
        }
    }

    public function eliminar(Request $request)
    {
        try {
            $iamgen = $this->imagenService->eliminar($request);
            return response()->json($iamgen,200);
        } catch (\Throwable $th) {
            return response()->json(['error' => $th->getMessage()], 400);
        }
    }
}
