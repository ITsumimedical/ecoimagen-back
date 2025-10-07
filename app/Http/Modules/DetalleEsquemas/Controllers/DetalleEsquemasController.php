<?php

namespace App\Http\Modules\DetalleEsquemas\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Modules\DetalleEsquemas\Repositories\DetalleEsquemaRepository;
use Illuminate\Http\Request;

class DetalleEsquemasController extends Controller
{
    public function __construct(private DetalleEsquemaRepository $esquemaRepository)
    {
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
