<?php

namespace App\Http\Modules\GraficasOms\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Modules\GraficasOms\Services\GraficasOmsService;
use App\Http\Modules\Reps\Models\Rep;
use Illuminate\Http\Request;

class GraficasOmsController extends Controller
{
    protected $graficasOmsService;

    public function __construct(GraficasOmsService $graficasOmsService)
    {
        $this->graficasOmsService = $graficasOmsService;
    }

    public function generarGraficaPesoTalla(Request $request)
    {
        try {
            $resultado = $this->graficasOmsService->generarGraficaPesoTalla($request);
            return response()->json($resultado, 200);
        } catch (\Throwable $th) {
            return response()->json(['error' => $th->getMessage()], 400);
        }
    }

    public function generarGraficaTallaEdad(Request $request)
    {
        try {
            $resultado = $this->graficasOmsService->generarGraficaTallaEdad($request);
            return response()->json($resultado, 200);
        } catch (\Throwable $th) {
            return response()->json(['error' => $th->getMessage()], 400);
        }
    }

    public function generarGraficaPerimetroCefalico(Request $request)
    {
        try {
            $resultado = $this->graficasOmsService->generarGraficaPerimetroCefalico($request);
            return response()->json($resultado, 200);
        } catch (\Throwable $th) {
            return response()->json(['error' => $th->getMessage()], 400);
        }
    }

    public function generarGraficaIMC(Request $request)
    {
        try {
            $resultado = $this->graficasOmsService->generarGraficaIMC($request);
            return response()->json($resultado, 200);
        } catch (\Throwable $th) {
            return response()->json(['error' => $th->getMessage()], 400);
        }
    }

    public function generarGraficaPesoEdad(Request $request)
    {
        try {
            $resultado = $this->graficasOmsService->generarGraficaPesoEdad($request);
            return response()->json($resultado, 200);
        } catch (\Throwable $th) {
            return response()->json(['error' => $th->getMessage()], 400);
        }
    }

}

