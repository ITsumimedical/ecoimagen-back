<?php

namespace App\Http\Modules\Esquemas\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Modules\Esquemas\Repositories\EsquemaRepository;
use Illuminate\Http\Request;
use Symfony\Component\HttpKernel\HttpCache\Esi;

class EsquemaController extends Controller
{

    public function __construct(private EsquemaRepository $esquemaRepository)
    {
    }


    public function listar(Request $request){
        try {
            $bodegas = $this->esquemaRepository->listarEsquema($request);
            return response()->json($bodegas, 200);
        } catch (\Throwable $th) {
            return response()->json($th->getMessage(), 400);
        }
    }


    public function crear(Request $request){
        try {
            $bodegas = $this->esquemaRepository->crear($request->all());
            return response()->json($bodegas, 201);
        } catch (\Throwable $th) {
            return response()->json($th->getMessage(), 400);
        }
    }

    public function actualizar(Request $request, int $id)
    {
        try {
            $esquema = $this->esquemaRepository->buscar($id);
            $esquema->fill($request->all());
            $this->esquemaRepository->guardar($esquema);
            return response()->json([
                'mensaje' => 'El esquema fue actualizado con exito!'
            ],201);

        } catch (\Throwable $th) {
            return response()->json([
                'mensaje' => $th->getMessage()
            ], 400);
        }
    }
}
