<?php

namespace App\Http\Modules\FuncionRenal\Controller;

use App\Http\Controllers\Controller;
use App\Http\Modules\FuncionRenal\Repositories\FuncionRenalRepository;
use App\Http\Modules\FuncionRenal\Services\FuncionRenalService;
use Illuminate\Http\Request;
use Illuminate\Http\Response;


class FuncionRenalController extends Controller
{
       public function __construct(
        protected FuncionRenalRepository $funcionRenalRepository,
        protected FuncionRenalService $funcionRenalService

    ) {}

     public function listarFuncionRenal(Request $request)
    {
        try {
            $resultadoFr =  $this->funcionRenalRepository->listarFuncionRenal($request->all());
            return response()->json($resultadoFr);
        } catch (\Throwable $th) {
            return response()->json([
                'mensaje' => 'error al consultar los resultados de funcion renal'
            ], Response::HTTP_BAD_REQUEST);
        }
    }

     public function guardarResultadosFr(Request $request)
    {
        try {
            $guardadoFr =  $this->funcionRenalService->guardarResultadosFr($request);
            return response()->json($guardadoFr);
        } catch (\Throwable $th) {
            return response()->json([
                'mensaje' => 'error al guardar los resultados de funcion renal'
            ], Response::HTTP_BAD_REQUEST);
        }
    }


}
