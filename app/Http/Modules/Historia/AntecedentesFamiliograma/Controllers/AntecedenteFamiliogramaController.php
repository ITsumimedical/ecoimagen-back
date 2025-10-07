<?php

namespace App\Http\Modules\Historia\AntecedentesFamiliograma\Controllers;

use Illuminate\Http\Response;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Modules\Historia\AntecedentesFamiliograma\Repositories\AntecedenteFamiliogramaRepository;
use App\Http\Modules\Historia\AntecedentesFamiliograma\Requests\AntecedenteFamiliogramaRequest;
use App\Http\Modules\Historia\AntecedentesFamiliograma\Services\AntecedenteFamiliogramaService;

class AntecedenteFamiliogramaController extends Controller
{
    public function __construct(protected AntecedenteFamiliogramaRepository $antecedenteFamiliogramaRepository,
                                protected AntecedenteFamiliogramaService $antecedenteFamiliogramaService) {
    }

    public function guardarFamiliograma(Request $request) {
        try {
            $this->antecedenteFamiliogramaRepository->crearFamiliograma($request->all());
            return response()->json([
                'mensaje' => 'Los antecedentes familiograma guardados con exito.'
            ], Response::HTTP_CREATED);
        } catch (\Throwable $th) {
            return response()->json([
                'error' => $th->getMessage()
            ], Response::HTTP_BAD_REQUEST);
        }
    }

    public function listarFamiliograma(Request $request) {
        try {
            $antecedentes =  $this->antecedenteFamiliogramaRepository->listarAntecedentesFamiliograma($request);
            return response()->json($antecedentes);
        } catch (\Throwable $th) {
            return response()->json([
                'error' => $th->getMessage(),
                'mensaje' => 'error al consultar los antecedentes familiograma'
            ], Response::HTTP_BAD_REQUEST);
        }
    }

    public function obtenerDatosFamiliograma($afiliadoId)
    {
        try {
            $familiograma = $this->antecedenteFamiliogramaRepository->obtenerDatosFamiliograma($afiliadoId);
            return response()->json($familiograma, Response::HTTP_OK);
        } catch (\Throwable $th) {
            return response()->json(['Error' => $th->getMessage()], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }
}
