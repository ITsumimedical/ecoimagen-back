<?php

namespace App\Http\Modules\ProgramasFarmacia\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Modules\ProgramasFarmacia\Repositories\ProgramasBodegasRepository;
use App\Http\Modules\ProgramasFarmacia\Request\CrearProgramasBodegasRequest;
use Illuminate\Http\Request;

class ProgramasBodegasController extends Controller
{
    public function __construct(protected ProgramasBodegasRepository $programasFarmaciaRepository)
    {
    }

    public function crearPrograma(CrearProgramasBodegasRequest $request)
    {
        $programa_farmacia_id = $request->input('programa_farmacia_id');
        $bodega_id = $request->input('bodega_id');

        try {
            $resultado = $this->programasFarmaciaRepository->AñadirBodegaPrograma($programa_farmacia_id, $bodega_id);
            if ($resultado) {
                return response()->json(['message' => 'Bodegas asignadas correctamente'], 201);
            } else {
                return response()->json(['error' => 'No se pudo asignar las bodegas al programa'], 400);
            }
        } catch (\Exception $th) {
            return response()->json(['error' => $th->getMessage()], 500);
        }
    }

    public function listarBodegas($programa_farmacia_id)
    {
        try {
            $bodegas = $this->programasFarmaciaRepository->listarBodegasPorPrograma($programa_farmacia_id);

            if ($bodegas) {
                return response()->json(['bodegas' => $bodegas], 200);
            } else {
                return response()->json(['message' => 'No se encontró el programa farmacia o no tiene bodegas asociadas'], 404);
            }
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 400);
        }
    }

    public function eliminarBodegaPrograma(Request $request)
    {
        $programa_farmacia_id = $request->input('programa_farmacia_id');
        $bodega_id = $request->input('bodega_id');
        if (!is_array($bodega_id)) {
            return response()->json(['error' => 'bodega_id debe ser un array'], 400);
        }

        try {
            $resultado = $this->programasFarmaciaRepository->eliminarBodegasPrograma($programa_farmacia_id, $bodega_id);
            if ($resultado) {
                return response()->json(['message' => 'Bodegas eliminadas del programa correctamente'], 200);
            } else {
                return response()->json(['error' => 'No se pudieron eliminar las bodegas del programa'], 400);
            }
        } catch (\Exception $th) {
            return response()->json(['error' => $th->getMessage()], 500);
        }
    }
}
