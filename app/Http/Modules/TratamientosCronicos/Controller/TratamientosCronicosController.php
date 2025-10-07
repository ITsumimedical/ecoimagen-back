<?php

namespace App\Http\Modules\TratamientosCronicos\Controller;

use App\Http\Controllers\Controller;
use App\Http\Modules\TratamientosCronicos\Repositories\TratamientosCronicosRepository;
use App\Http\Modules\TratamientosCronicos\Requests\CrearTratamientosCronicosRequest;
use Illuminate\Http\Request;

class TratamientosCronicosController extends Controller
{
    public function __construct(
        protected TratamientosCronicosRepository $tratamientosCronicosRepository,
    ) {}

    public function crear(CrearTratamientosCronicosRequest $request)
    {
        try {
            $tratamiento = $this->tratamientosCronicosRepository->crear($request->validated());
            return response()->json($tratamiento, 201);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

    public function listarPorAfiliado(int $afiliado_id)
    {
        try {
            $tratamientos = $this->tratamientosCronicosRepository->listarTratamientosPorAfiliado($afiliado_id);
            return response()->json($tratamientos, 200);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

    public function eliminarTratamiento(int $tratamiento_id)
    {
        try {
            $this->tratamientosCronicosRepository->eliminar($tratamiento_id);
            return response()->json(['mensaje' => 'Tratamiento eliminado correctamente'], 200);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }
}
