<?php

namespace App\Http\Modules\NotasEnfermeria\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Http\Controllers\Controller;
use App\Http\Modules\NotasEnfermeria\Repositories\NotasEnfermeriaRepository;

class NotasEnfermeriaController extends Controller
{
    public function __construct(protected NotasEnfermeriaRepository $notasEnfermeriaRepository) {
    }

    public function listar(Request $request){
        try {
            $nota = $this->notasEnfermeriaRepository->listarNotas($request->orden_id);
            return response()->json($nota,Response::HTTP_OK);
        } catch (\Throwable $th) {
            return response()->json([
                'mensaje' => $th->getMessage()
            ], Response::HTTP_BAD_REQUEST);
        }
    }


    public function guardar(Request $request){
        try {
            $nota = $this->notasEnfermeriaRepository->crear($request->all());
            return response()->json($nota,Response::HTTP_OK);
        } catch (\Throwable $th) {
            return response()->json([
                'mensaje' => $th->getMessage()
            ], Response::HTTP_BAD_REQUEST);
        }
    }

}
