<?php

namespace App\Http\Modules\ConductasInadaptativas\Controller;

use App\Http\Controllers\Controller;
use App\Http\Modules\ConductasInadaptativas\Repositories\ConductaInadaptativaRepository;
use Illuminate\Http\Request;

class ConductaInadaptativaController extends Controller
{
    public function __construct(
        protected ConductaInadaptativaRepository $conductaInadaptativaRepository,
    ) {}

    public function crear(Request $request)
    {
        try {
            $conducta = $this->conductaInadaptativaRepository->crearConducta($request->all());
            return response()->json($conducta);
        } catch (\Throwable $th) {
            return response()->json(['error' => $th->getMessage()],400);
        }
    }
}
