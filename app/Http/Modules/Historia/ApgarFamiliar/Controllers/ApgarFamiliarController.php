<?php

namespace App\Http\Modules\Historia\ApgarFamiliar\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Http\Controllers\Controller;
use App\Http\Modules\Historia\ApgarFamiliar\Repositories\ApgarFamiliarRepository;

class ApgarFamiliarController extends Controller
{
    public function __construct(protected ApgarFamiliarRepository $apgarFamiliarRepository) {
    }

    public function guardarApgar(Request $request) {
        try {
        $antecedentes =   $this->apgarFamiliarRepository->crearApgar($request->all());
            return response()->json([
                'mensaje' => 'Los antecedentes ecomapa guardados con exito.'
            ], Response::HTTP_CREATED);
        } catch (\Throwable $th) {
            return response()->json([
                'error' => $th->getMessage()
            ], Response::HTTP_BAD_REQUEST);
        }
    }

    public function listarApgar(Request $request) {
        try {
            $antecedentes =  $this->apgarFamiliarRepository->listarApgar($request);
            return response()->json($antecedentes);
        } catch (\Throwable $th) {
            return response()->json([
                'mensaje' => 'error al consultar los antecedentes ecomapa'
            ], Response::HTTP_BAD_REQUEST);
        }
    }

    public function obtenerDatosApgar($afiliadoId)
    {
        try {
            $apgar = $this->apgarFamiliarRepository->obtenerDatosApgar($afiliadoId);
            return response()->json($apgar, Response::HTTP_OK);
        } catch (\Throwable $th) {
            return response()->json(['Error' => $th->getMessage()], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }
}
