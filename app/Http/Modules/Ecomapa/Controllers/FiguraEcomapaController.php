<?php

namespace App\Http\Modules\Ecomapa\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Modules\Ecomapa\Request\ConsultarImagenEcomapaRequest;
use App\Http\Modules\Ecomapa\Request\CrearFiguraEcomapaRequest;
use App\Http\Modules\Ecomapa\Request\GuardarImagenEcomapaRequest;
use App\Http\Modules\Ecomapa\Request\ObtenerFiguraEcomapaRequest;
use App\Http\Modules\Ecomapa\Services\FiguraEcomapaService;
use Illuminate\Http\Request;

class FiguraEcomapaController extends Controller
{
    protected $figuraService;

    public function __construct(FiguraEcomapaService $figuraService)
    {
        $this->figuraService = $figuraService;
    }

    public function listarFiguras()
    {
        try {
            $figuras = $this->figuraService->listarFiguras();

            return response()->json($figuras, 200);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Error al listar las figuras: ' . $e->getMessage()], 500);
        }
    }

    public function crearFigura(CrearFiguraEcomapaRequest $request)
    {
        try {
            $ecomapa = $this->figuraService->crearFigura($request->validated());

            return response()->json($ecomapa, 201);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Error al crear la figura: ' . $e->getMessage()], 500);
        }
    }

    public function guardarImagen(GuardarImagenEcomapaRequest $request)
    {
        try {
            $ecomapa = $this->figuraService->guardarImagen($request->validated());

            return response()->json($ecomapa, 201);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Error al guardar la imagen: ' . $e->getMessage()], 500);
        }
    }

    public function consultarImagen(ConsultarImagenEcomapaRequest $request)
    {
        try {
            $url = $this->figuraService->consultarImagen($request->validated());

            return response()->json(['url' => $url], 200);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Error al consultar la imagen: ' . $e->getMessage()], 500);
        }
    }

    public function obtenerFigura(ObtenerFiguraEcomapaRequest $request)
    {
        try {
            $figuras = $this->figuraService->obtenerFigura($request->validated());

            return response()->json($figuras, 200);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Error al obtener las figuras: ' . $e->getMessage()], 500);
        }
    }


    // public function actualizarFigura(Request $request, $id)
    // {
    //     $request->validate([
    //         'nombre' => 'sometimes|string|max:255',
    //         'edad' => 'sometimes|string',
    //         'pos_x' => 'sometimes|integer',
    //         'pos_y' => 'sometimes|integer',
    //     ]);

    //     return response()->json($this->figuraService->actualizarFigura($id, $request->all()));
    // }

    // public function eliminarFigura($id)
    // {
    //     return response()->json($this->figuraService->eliminarFigura($id));
    // }
}
