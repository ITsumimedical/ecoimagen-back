<?php

namespace App\Http\Modules\SucesionEvolutiva\Controller;

use App\Http\Controllers\Controller;
use App\Http\Modules\SucesionEvolutiva\Repositories\SucesionEvolutivaRepository;
use App\Http\Modules\SucesionEvolutiva\Request\CrearSucesionEvolutivaRequest;
use Illuminate\Http\Request;

class SucesionEvolutivaController extends Controller
{
    public function __construct(
        protected SucesionEvolutivaRepository $sucesionEvolutivaRepository,
    ) {}

    public function crear(CrearSucesionEvolutivaRequest $request)
    {
        try {
            $sucesion = $this->sucesionEvolutivaRepository->crearSucesion($request->validated());
            return response()->json($sucesion);
        } catch (\Throwable $th) {
            return response()->json(['error' => $th->getMessage()], 400);
        }
    }

    public function obtenerDatosSucesionEvolutivaPorAfiliado($afiliadoId)
    {
        try {
            $sucesion = $this->sucesionEvolutivaRepository->obtenerDatosSucesionEvolutivaPorAfiliado($afiliadoId);
            return response()->json($sucesion);
        } catch (\Throwable $th) {
            return response()->json(['error' => $th->getMessage()], 400);
        }
    }

}
