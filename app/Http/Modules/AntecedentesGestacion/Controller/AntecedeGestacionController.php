<?php

namespace App\Http\Modules\AntecedentesGestacion\Controller;

use App\Http\Controllers\Controller;
use App\Http\Modules\AntecedentesGestacion\Repositories\AntecedeGestacionRepository;
use Illuminate\Http\Request;

class AntecedeGestacionController extends Controller
{
    public function __construct(
        protected AntecedeGestacionRepository $antecedenteGestacionRepository,
    ) {}

    public function crear(Request $request)
    {
        try {
            $antecedentes = $this->antecedenteGestacionRepository->crearAntecedente($request->all());
            return response()->json($antecedentes);
        } catch (\Throwable $th) {
            return response()->json(['error' => $th->getMessage()], 400);
        }
    }

    public function obtenerDatos($afiliadoId)
    {
        try {
            $datos = $this->antecedenteGestacionRepository->obtenerdatos($afiliadoId);
            return response()->json($datos);
        } catch (\Throwable $th) {
            return response()->json(['error' => $th->getMessage()], 400);
        }
    }

    public function eliminar($id)
    {
        try {
            $this->antecedenteGestacionRepository->eliminarAyudaDiagnostica($id);
            return response()->json(['mensaje' => 'Eliminado con éxito'], 200);
        } catch (\Throwable $th) {
            return response()->json(['Error' => $th->getMessage()], 400);
        }
    }
}
