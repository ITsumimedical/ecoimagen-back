<?php

namespace App\Http\Modules\FiguraHumana\Controller;

use App\Http\Controllers\Controller;
use App\Http\Modules\FiguraHumana\Repositories\FiguraHumanaRepository;
use Illuminate\Http\Request;

class FiguraHumanaController extends Controller
{
    public function __construct(
        protected FiguraHumanaRepository $figuraHumanaRepository,
    ) {}

    public function crear(Request $request)
    {
        try {
            $figura = $this->figuraHumanaRepository->crearFiguraHumana($request->all());
            return response()->json($figura);
        } catch (\Throwable $th) {
            return response()->json(['error' => $th->getMessage()], 400);
        }
    }

    public function obtenerPorAfiliado($afiliadoId)
    {
        try {
            $datos = $this->figuraHumanaRepository->obtenerDatosporAfiliado($afiliadoId);
            return response()->json($datos);
        } catch (\Throwable $th) {
            return response()->json(['error' => $th->getMessage()], 400);
        }
    }
}
