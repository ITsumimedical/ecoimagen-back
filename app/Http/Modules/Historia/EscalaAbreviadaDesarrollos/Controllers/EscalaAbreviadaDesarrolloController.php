<?php

namespace App\Http\Modules\Historia\EscalaAbreviadaDesarrollos\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Modules\Historia\EscalaAbreviadaDesarrollos\Repositories\EscalaAbreviadaRepository;

class EscalaAbreviadaDesarrolloController extends Controller
{
    public function __construct(
        private EscalaAbreviadaRepository $escalaAbreviadaRepository
    ) {
    }

    public function listarEscalaAbreviada(Request $request)
    {
        try {
            $listar = $this->escalaAbreviadaRepository->listarEscalaAbreviada($request);
            return response()->json($listar, 200);
        } catch (\Throwable $th) {
            return response()->json([
                'message' => 'Error al listar la escala abreviada',
                'error' => env('APP_ENV') === 'local' ? $th->getMessage() : null,
            ], $th->getCode() >= 100 && $th->getCode() < 600 ? $th->getCode() : 500);
        }
    }
    public function convertirPd(Request $request)
    {
        try {
            $convertir = $this->escalaAbreviadaRepository->convertirPd($request);
            return response()->json($convertir, 200);
        } catch (\Throwable $th) {
            return response()->json([
                'message' => 'Error al realizar la conversion',
                'error' => env('APP_ENV') === 'local' ? $th->getMessage() : null,
            ], $th->getCode() >= 100 && $th->getCode() < 600 ? $th->getCode() : 500);
        }
    }
}
