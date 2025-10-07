<?php

namespace App\Http\Modules\Historia\AntecedentesFarmacologicos\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Http\Controllers\Controller;
use App\Http\Modules\Historia\AntecedentesFarmacologicos\Repositories\AntecedentesFarmacologicosRepository;

class AntecedentesFarmacologicosController extends Controller
{
    public function __construct(private AntecedentesFarmacologicosRepository $antecedentesFarmacologicosRepository) {

    }

    public function listarAlergiaMedicamentos(Request $request) {
        try {
            $antecedentes =  $this->antecedentesFarmacologicosRepository->listarAlergiaMedicamento($request);
            return response()->json($antecedentes);
        } catch (\Throwable $th) {
            return response()->json([
                $th->getMessage(),
                'mensaje' => 'error al consultar los antecedentes quirurgicos'
            ], Response::HTTP_BAD_REQUEST);
        }
    }

    public function guardar(Request $request) {
        try {
            $this->antecedentesFarmacologicosRepository->crear($request->all());
            return response()->json([
                'mensaje' => 'Los antecedentes quirurgicos guardados con exito.'
            ], Response::HTTP_CREATED);
        } catch (\Throwable $th) {
            return response()->json([
                'error' => $th->getMessage()
            ], Response::HTTP_BAD_REQUEST);
        }
    }

    public function listarAlergiaAmbiental(Request $request) {
        try {
            $antecedentes =  $this->antecedentesFarmacologicosRepository->listarAlergiaAmbiental($request);
            return response()->json($antecedentes);
        } catch (\Throwable $th) {
            return response()->json([
                $th->getMessage(),
                'mensaje' => 'error al consultar los antecedentes quirurgicos'
            ], Response::HTTP_BAD_REQUEST);
        }
    }

    public function listarAlergiaAlimentos(Request $request) {
        try {
            $antecedentes =  $this->antecedentesFarmacologicosRepository->listarAlergiaAlimentos($request);
            return response()->json($antecedentes);
        } catch (\Throwable $th) {
            return response()->json([
                'mensaje' => 'error al consultar los antecedentes quirurgicos'
            ], Response::HTTP_BAD_REQUEST);
        }
    }

    public function listarOtras(Request $request) {
        try {
            $antecedentes =  $this->antecedentesFarmacologicosRepository->listarOtras($request);
            return response()->json($antecedentes);
        } catch (\Throwable $th) {
            return response()->json([
                'mensaje' => 'error al consultar los antecedentes quirurgicos'
            ], Response::HTTP_BAD_REQUEST);
        }
    }

    public function eliminarAlergia($id) {
        try {
            $antecedentes =  $this->antecedentesFarmacologicosRepository->eliminarAlergia($id);
            return response()->json($antecedentes);
        } catch (\Throwable $th) {
            return response()->json([
                'mensaje' => 'Error al eliminar la alergia de medicamento'
            ], Response::HTTP_BAD_REQUEST);
        }
    }
}
