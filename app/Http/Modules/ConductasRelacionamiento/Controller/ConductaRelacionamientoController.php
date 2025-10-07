<?php

namespace App\Http\Modules\ConductasRelacionamiento\Controller;

use App\Http\Controllers\Controller;
use App\Http\Modules\ConductasRelacionamiento\Repositories\ConductaRelacionamientoRepository;
use Illuminate\Http\Request;

class ConductaRelacionamientoController extends Controller
{
    public function __construct(
        protected ConductaRelacionamientoRepository $conductaRelacionamientoRepository,
    ) {}

    public function crear(Request $request)
    {
        try {
            $conducta = $this->conductaRelacionamientoRepository->crearConducta($request->all());
            return response()->json($conducta);
        } catch (\Throwable $th) {
            return response()->json(['error' => $th->getMessage()], 400);
        }
    }
}
