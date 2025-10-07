<?php

namespace App\Http\Modules\EscalaDolor\Controller;

use App\Http\Controllers\Controller;
use App\Http\Modules\EscalaDolor\Repositories\EscalaDolorRepository;
use Illuminate\Http\Request;

class EscalaDolorController extends Controller
{
    public function __construct(
        protected EscalaDolorRepository $escalaDolorRepository,
    ) {}

    public function crear(Request $request)
    {
        try {
            $escala = $this->escalaDolorRepository->crearEscala($request->all());
            return response()->json($escala);
        } catch (\Throwable $th) {
            return response()->json(['error' => $th->getMessage()], 400);
        }
    }


    public function obtenerDatos($afiliadoId)
    {
        try {
            $rqc = $this->escalaDolorRepository->obtenerDatosporAfiliado($afiliadoId);
            return response()->json($rqc);
        } catch (\Throwable $th) {
            return response()->json(['error' => $th->getMessage()], 400);
        }
    }
}
