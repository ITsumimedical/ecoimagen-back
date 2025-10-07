<?php

namespace App\Http\Modules\rqc\Controller;

use App\Http\Controllers\Controller;
use App\Http\Modules\rqc\Repositories\rqcRepository;
use App\Http\Modules\rqc\Request\CrearRqcRequest;
use Illuminate\Http\Request;

class RqcController extends Controller
{
    public function __construct(
        protected rqcRepository $rqcRepository,
    ) {}

    public function crear(CrearRqcRequest $request)
    {
        try {
            $rqc = $this->rqcRepository->crearRqc($request->validated());
            return response()->json($rqc);
        } catch (\Throwable $th) {
            return response()->json(['error' => $th->getMessage()], 400);
        }
    }

    public function obtenerDatos($afiliadoId)
    {
        try {
            $rqc = $this->rqcRepository->obtenerDatosporAfiliado($afiliadoId);
            return response()->json($rqc);
        } catch (\Throwable $th) {
            return response()->json(['error' => $th->getMessage()], 400);
        }
    }

}
