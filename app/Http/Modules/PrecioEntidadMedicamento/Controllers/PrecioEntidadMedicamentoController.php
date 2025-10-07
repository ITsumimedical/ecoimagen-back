<?php

namespace App\Http\Modules\PrecioEntidadMedicamento\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Http\Controllers\Controller;
use App\Http\Modules\PrecioEntidadMedicamento\Repositories\PrecioEntidadMedicamentoRepository;

class PrecioEntidadMedicamentoController extends Controller
{
    public function __construct(private PrecioEntidadMedicamentoRepository $precioEntidadMedicamentoRepository) {

    }

    public function listar(Request $request){
        try {
            $precio = $this->precioEntidadMedicamentoRepository->listarPrecio($request->all());
            return response()->json($precio, 200);
        } catch (\Throwable $th) {
            return response()->json($th->getMessage(), 400);
        }
    }

    public function crear(Request $request)
    {
        try {
            $precio = $this->precioEntidadMedicamentoRepository->crear($request->all());
            return response()->json($precio, 201);
        } catch (\Throwable $th) {
            return response()->json($th->getMessage(), 400);
        }
    }

    public function actualizar(Request $request, int $id)
    {
        try {
            $precio = $this->precioEntidadMedicamentoRepository->buscar($id);
            $precio->fill($request->all());
            $responsableUpdate = $this->precioEntidadMedicamentoRepository->guardar($precio);
            return response()->json([
                'res' => true,
                'mensaje' => 'Actualizado con exito!.'
            ], Response::HTTP_OK);
        } catch (\Throwable $th) {
            return response()->json([
                'res' => false,
                'mensaje' => $th->getMessage(),
            ], Response::HTTP_BAD_REQUEST);
        }
    }
}
