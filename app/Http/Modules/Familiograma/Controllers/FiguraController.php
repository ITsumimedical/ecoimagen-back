<?php

namespace App\Http\Modules\Familiograma\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Modules\Familiograma\Services\FiguraService;
use App\Http\Modules\Historia\Models\Familiograma;

class FiguraController extends Controller
{
    protected $figuraService;

    public function __construct(FiguraService $figuraService)
    {
        $this->figuraService = $figuraService;
    }

    public function listarFiguras()
    {
        return response()->json($this->figuraService->listarFiguras());
    }

    public function crearFigura(Request $request)
    {
        return response()->json($this->figuraService->crearFigura($request->all()));
    }

    public function guardarImagen(Request $request)
    {
        return response()->json($this->figuraService->guardarImagen($request->all()));
    }

    public function consultarImagen(Request $request)
    {
        return response()->json($this->figuraService->consultarImagen($request));
    }

    public function obtenerFigura(Request $request)
    {
        return response()->json($this->figuraService->obtenerFigura($request));
    }

    public function actualizarFigura(Request $request, $id)
    {
        $request->validate([
            'nombre' => 'sometimes|string|max:255',
            'edad' => 'sometimes|string',
            'pos_x' => 'sometimes|integer',
            'pos_y' => 'sometimes|integer',
        ]);

        return response()->json($this->figuraService->actualizarFigura($id, $request->all()));
    }

    public function eliminarFigura($id)
    {
        return response()->json($this->figuraService->eliminarFigura($id));
    }

    public function descargarGuia()
    {
        $filePath = public_path('documentosHistoriaClinica/familiograma.pdf');

        return response()->file($filePath, [
            'Content-Type' => 'application/pdf',
        ]);
    }
}
