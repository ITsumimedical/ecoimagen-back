<?php

namespace App\Http\Modules\EstadoAnimoComportamiento\Controller;

use App\Http\Controllers\Controller;
use App\Http\Modules\EstadoAnimoComportamiento\Repositories\EstadoAnimoComportamientoRepository;
use Illuminate\Http\Request;

class EstadoAnimoComportamientoController extends Controller
{
    public function __construct(
        protected EstadoAnimoComportamientoRepository $estadoAnimoComportamientoRepository,
    ) {}

    public function crear(Request $request)
    {
        try {
            $estado = $this->estadoAnimoComportamientoRepository->crearEstado($request->all());
            return response()->json($estado);
        } catch (\Throwable $th) {
            return response()->json(['error' => $th->getMessage()], 400);
        }
    }

    public function obtenerDatos($afiliadoId)
    {
        try {
            $estadoAnimo = $this->estadoAnimoComportamientoRepository->obtenerDatosporAfiliado($afiliadoId);
            return response()->json($estadoAnimo);
        } catch (\Throwable $th) {
            return response()->json(['error' => $th->getMessage()], 400);
        }
    }
}
