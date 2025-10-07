<?php

namespace App\Http\Modules\TratamientosBiologicos\Controller;

use App\Http\Controllers\Controller;
use App\Http\Modules\TratamientosBiologicos\Repositories\TratamientosBiologicosRepository;
use App\Http\Modules\TratamientosBiologicos\Request\CrearTratamientosBiologicosRequest;
use Illuminate\Http\Request;

class TratamientosBiologicosController extends Controller
{
     public function __construct(
        protected TratamientosBiologicosRepository $tratamientosBiologicosRepository,
    ) {}

    public function crear(CrearTratamientosBiologicosRequest $request)
    {
        try {
            $tratamiento = $this->tratamientosBiologicosRepository->crear($request->validated());
            return response()->json($tratamiento, 201);
        } catch (\Throwable $th) {
            return response()->json(['error' => $th->getMessage()], 400);
        }
    }

    public function listarTratamientoPorAfiliado(int $afiliado_id)
    {
        try {
            $tratamiento = $this->tratamientosBiologicosRepository->listarTratamientosPorAfiliado($afiliado_id);
            return response()->json($tratamiento);
        } catch (\Throwable $th) {
            return response()->json(['error' => $th->getMessage()]);
        }
    }

    public function eliminarTratamiento(int $id)
    {
        try {
            $this->tratamientosBiologicosRepository->eliminar($id);
            return response()->json(['elminado con éxito']);
        } catch (\Throwable $th) {
            return response()->json(['error' => $th->getMessage()], 400);
        }
    }
}
