<?php

namespace App\Http\Modules\Historia\Antecedentes\Controllers;

use Illuminate\Http\Response;
use App\Http\Controllers\Controller;
use App\Http\Modules\Historia\Antecedentes\Requests\AntecedenteRequest;
use App\Http\Modules\Historia\Antecedentes\Repositories\AntecedenteRepository;
use App\Http\Modules\Historia\Antecedentes\Services\AntecedenteService;

class AntecedenteController extends Controller
{
    public function __construct(protected AntecedenteRepository $antecedenteRepository,
                                protected AntecedenteService $antecedenteService) {
    }

    public function guardar(AntecedenteRequest $request) {
        try {
            $this->antecedenteService->guardarAntecedentes($request->validated());
            return response()->json([
                'mensaje' => 'Los antecedentes guardados con exito.'
            ], Response::HTTP_CREATED);
        } catch (\Throwable $th) {
            return response()->json([
                'error' => $th->getMessage()
            ], Response::HTTP_BAD_REQUEST);
        }
    }

    public function listar() {
        try {
            $antecedentes =  $this->antecedenteRepository->listarAntecedentes();
            return response()->json($antecedentes);
        } catch (\Throwable $th) {
            return response()->json([
                'mensaje' => 'error al consultar los antecedentes'
            ], Response::HTTP_BAD_REQUEST);
        }
    }
}
