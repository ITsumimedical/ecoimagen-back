<?php

namespace App\Http\Modules\testSrq\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Modules\testSrq\Repositories\srqRepository;
use App\Http\Modules\testSrq\Request\CrearSrqRequest;
use Illuminate\Http\Request;

class SrqController extends Controller
{
    public function __construct(
        protected srqRepository $srqRepository,
    ) {}

    public function crear(CrearSrqRequest $request)
    {
        try {
            $srq = $this->srqRepository->crearSrq($request->validated());
            return response()->json($srq);
        } catch (\Throwable $th) {
            return response()->json(['error' => $th->getMessage()], 400);
        }
    }

    public function obtenerDatos($afiliadoId)
    {
        try {
            $rqc = $this->srqRepository->obtenerDatosporAfiliado($afiliadoId);
            return response()->json($rqc);
        } catch (\Throwable $th) {
            return response()->json(['error' => $th->getMessage()], 400);
        }
    }


}
