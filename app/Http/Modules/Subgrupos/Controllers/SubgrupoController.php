<?php

namespace App\Http\Modules\Subgrupos\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Modules\Subgrupos\Repositories\SubgrupoRepository;
use Illuminate\Http\Request;

class SubgrupoController extends Controller
{
    public function __construct( private SubgrupoRepository $subgrupoRepository) {
    }

    public function listar(Request $request){
        try {
            $bodegas = $this->subgrupoRepository->listar($request);
            return response()->json($bodegas, 200);
        } catch (\Throwable $th) {
            return response()->json($th->getMessage(), 400);
        }
    }

    public function crear(Request $request){
        try {
            $bodegas = $this->subgrupoRepository->crear($request->all());
            return response()->json($bodegas, 201);
        } catch (\Throwable $th) {
            return response()->json($th->getMessage(), 400);
        }
    }

    public function actualizar(Request $request, int $id)
    {
        try {
            $bodegas = $this->subgrupoRepository->actualizarGrupo($request->all(),$id);
            return response()->json([
                'mensaje' => 'Subgrupo actualizado con exito!.'
            ],200);

        } catch (\Throwable $th) {
            return response()->json([
                'mensaje' => $th->getMessage()
            ], 400);
        }
    }
}
