<?php

namespace App\Http\Modules\Grupos\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Modules\Grupos\Repositories\GrupoRepository;
use Illuminate\Http\Request;

class GrupoController extends Controller
{
    public function __construct( private GrupoRepository $grupoRepository) {
    }

    public function listar(Request $request){
        try {
            $bodegas = $this->grupoRepository->listar($request);
            return response()->json($bodegas, 200);
        } catch (\Throwable $th) {
            return response()->json($th->getMessage(), 400);
        }
    }

    public function crear(Request $request){
        try {
            $bodegas = $this->grupoRepository->crear($request->all());
            return response()->json($bodegas, 201);
        } catch (\Throwable $th) {
            return response()->json($th->getMessage(), 400);
        }
    }

    public function actualizar(Request $request, int $id)
    {
        try {
            $bodegas = $this->grupoRepository->actualizarGrupo($request->all(),$id);
            return response()->json([
                'mensaje' => 'grupo actualizado con exito!.'
            ],200);

        } catch (\Throwable $th) {
            return response()->json([
                'mensaje' => $th->getMessage()
            ], 400);
        }
    }
}
