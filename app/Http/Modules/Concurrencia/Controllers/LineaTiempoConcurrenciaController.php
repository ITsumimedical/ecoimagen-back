<?php

namespace App\Http\Modules\Concurrencia\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Modules\Concurrencia\Repositories\LineaTiempoConcurrenciaRepository;
use Illuminate\Http\Request;

class LineaTiempoConcurrenciaController extends Controller
{
    public function __construct(protected LineaTiempoConcurrenciaRepository $lineatiempoRepository)
    {
    }

    public function listarLinea(Request $request){
        try {
            $evento = $this->lineatiempoRepository->listarLinea($request);
            return response()->json($evento, 200);
        } catch (\Throwable $th) {
            return response()->json([
                'res' => false,
                'message' => 'Error al listar la línea temporal',
                'error' => $th->getMessage()
            ], 400);
        }
    }
}
