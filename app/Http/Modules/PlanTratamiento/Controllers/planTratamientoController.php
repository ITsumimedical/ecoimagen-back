<?php

namespace App\Http\Modules\PlanTratamiento\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Modules\PlanTratamiento\Repositories\planTratamientoRepository;
use Illuminate\Http\Request;

class planTratamientoController extends Controller
{
    public function __construct(
        private planTratamientoRepository $planTratamientoRepository,
    ) {
    }

    public function crear(Request $request)
    {
        try {
            $this->planTratamientoRepository->crear($request->all());
            return response()->json([
                'mensaje' => 'plan tratamiento guardado con éxito'
            ]);
        } catch (\Throwable $th) {
            return response()->json(['error' => $th->getMessage()], 400);
        }
    }
}
