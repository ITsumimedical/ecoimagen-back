<?php

namespace App\Http\Modules\RxFinal\Controller;

use App\Http\Controllers\Controller;
use App\Http\Modules\RxFinal\Repositories\RxFinalRepository;
use Illuminate\Http\Request;

class RxFinalController extends Controller
{
    public function __construct(
        protected RxFinalRepository $rxFinalRepository,
    ) {}

    public function crear(Request $request)
    {
        try {
            $rx = $this->rxFinalRepository->crearRx($request->all());
            return response()->json($rx);
        } catch (\Throwable $th) {
            return response()->json(['error' => $th->getMessage()], 400);
        }
    }

    public function listarOjoDerecho(Request $request)
    {
        try {
            $derecho = $this->rxFinalRepository->listarOjoDerecho($request->consulta_id);
            return response()->json($derecho);
        } catch (\Throwable $th) {
            return response()->json(['error' => $th->getMessage()], 400);
        }
    }

    public function listarOjoIzquierdo(Request $request)
    {
        try {
            $izquierdo = $this->rxFinalRepository->listarOjoIzquierdo($request->consulta_id);
            return response()->json($izquierdo);
        } catch (\Throwable $th) {
            return response()->json(['error' => $th->getMessage()], 400);
        }
    }
}
