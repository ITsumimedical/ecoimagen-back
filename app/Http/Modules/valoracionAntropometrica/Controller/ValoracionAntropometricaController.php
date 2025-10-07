<?php

namespace App\Http\Modules\valoracionAntropometrica\Controller;

use App\Http\Controllers\Controller;
use App\Http\Modules\valoracionAntropometrica\Repositories\ValoracionAntropometricaRepository;
use Illuminate\Http\Request;

class ValoracionAntropometricaController extends Controller
{
    public function __construct(
        protected ValoracionAntropometricaRepository $valoracionAntropometricaRepository,
    ) {}

    public function crear(Request $request)
    {
        try {
            $valoracion = $this->valoracionAntropometricaRepository->crear($request->all());
            return response()->json($valoracion);
        } catch (\Throwable $th) {
            return response()->json(['error' => $th->getMessage()],400);
        }
    }

    public function obtenerDatos($afiliadoId)
    {
        try {
            $valoracion = $this->valoracionAntropometricaRepository->obtenerDatosporAfiliado($afiliadoId);
            return response()->json($valoracion);
        } catch (\Throwable $th) {
            return response()->json(['error' => $th->getMessage()], 400);
        }
    }
}
