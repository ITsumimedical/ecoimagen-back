<?php

namespace App\Http\Modules\Medicamentos\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Modules\Medicamentos\Models\PrecioProveedorMedicamento;
use App\Http\Modules\Medicamentos\Repositories\PrecioRepository;
use App\Http\Modules\Proveedores\Models\Proveedor;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\DB;

class PrecioController extends Controller
{

    public function __construct(private PrecioRepository $precioRepository) {

    }

    public function preciosActuales($proveedor,Request $request){
        $precios = PrecioProveedorMedicamento::where('rep_id',$proveedor)->whereIn('medicamento_id',$request->all())->get();
        return response()->json($precios);

    }

    public function precioMedicamento(Request $request){
        $precios = PrecioProveedorMedicamento::where('medicamento_id',$request->medicamento)->with('rep')->get();
        return response()->json($precios,200);

    }

    public function crear(Request $request)
    {
        try {
            $sede = $this->precioRepository->crear($request->all());
            return response()->json($sede, 201);
        } catch (\Throwable $th) {
            return response()->json($th->getMessage(), 400);
        }
    }

    public function actualizar(Request $request, int $id)
    {
        try {
            $precio = $this->precioRepository->buscar($id);
            $precio->fill($request->all());
            $responsableUpdate = $this->precioRepository->guardar($precio);
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
