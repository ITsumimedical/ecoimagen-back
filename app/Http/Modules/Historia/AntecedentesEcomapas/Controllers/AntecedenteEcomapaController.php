<?php

namespace App\Http\Modules\Historia\AntecedentesEcomapas\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Http\Controllers\Controller;
use App\Http\Modules\Historia\AntecedentesEcomapas\Requests\AntecedenteEcomapaRequest;
use App\Http\Modules\Historia\AntecedentesEcomapas\Services\AntecedenteEcomapaService;
use App\Http\Modules\Historia\AntecedentesEcomapas\Repositories\AntecedenteEcomapaRepository;

class AntecedenteEcomapaController extends Controller
{
    public function __construct(protected AntecedenteEcomapaRepository $antecedenteEcomapaRepository,
                                protected AntecedenteEcomapaService $antecedenteEcomapaService) {
    }

    public function guardarEcomapa(Request $request) {
        try {
        $antecedentes =   $this->antecedenteEcomapaRepository->crearEcomapa($request->all());
            return response()->json([
                'mensaje' => 'Los antecedentes ecomapa guardados con exito.'
            ], Response::HTTP_CREATED);
        } catch (\Throwable $th) {
            return response()->json([
                'error' => $th->getMessage()
            ], Response::HTTP_BAD_REQUEST);
        }
    }

    public function listarEcomapa(Request $request) {
        try {
            $antecedentes =  $this->antecedenteEcomapaRepository->listarAntecedentesEcomapa($request);
            return response()->json($antecedentes);
        } catch (\Throwable $th) {
            return response()->json([
                'mensaje' => 'error al consultar los antecedentes ecomapa'
            ], Response::HTTP_BAD_REQUEST);
        }
    }

    public function obtenerDatos($afiliadoId)
    {
        try {
            $apgar = $this->antecedenteEcomapaRepository->obtenerDatosEcomapa($afiliadoId);
            return response()->json($apgar, Response::HTTP_OK);
        } catch (\Throwable $th) {
            return response()->json(['error' => $th->getMessage()], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }
}
