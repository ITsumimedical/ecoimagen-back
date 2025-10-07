<?php

namespace App\Http\Modules\Minuta\Controller;

use App\Http\Controllers\Controller;
use App\Http\Modules\Minuta\Repositories\MinutaRepository;
use Illuminate\Http\Request;

class MinutaController extends Controller
{
    public function __construct(
        protected MinutaRepository $minutaRepository,
    ) {}

    public function crear(Request $request)
    {
        try {
            $minuta = $this->minutaRepository->crearMinuta($request->all());
            return response()->json($minuta);
        } catch (\Throwable $th) {
            return response()->json(['error' => $th->getMessage()], 400);
        }
    }

    public function obtenerDatos($afiliadoId)
    {
        try {
            $minuta = $this->minutaRepository->obtenerDatosporAfiliado($afiliadoId);
            return response()->json($minuta);
        } catch (\Throwable $th) {
            return response()->json(['error' => $th->getMessage()], 400);
        }
    }


}
