<?php

namespace App\Http\Modules\Historia\AntecedentesSexuales\Controllers;

use Illuminate\Http\Response;
use App\Http\Controllers\Controller;
use App\Http\Modules\Historia\AntecedentesSexuales\Repositories\AntecedentesSexualesRepository;
use App\Http\Modules\Historia\AntecedentesSexuales\Requests\AntecedentesSexualesRequest;
use App\Http\Modules\Historia\AntecedentesSexuales\Services\AntecedentesSexualesService;

class AntecedenteSexualesController extends Controller
{
    public function __construct(protected AntecedentesSexualesRepository $antecedentesSexualesRepository,
                                protected AntecedentesSexualesService $antecedentesSexualesService) {
    }

    public function guardar(AntecedentesSexualesRequest $request) {
        try {
            $this->antecedentesSexualesService->guardarAntecedentes($request->validated());
            return response()->json([
                'mensaje' => 'Los antecedentes sexuales guardados con exito.'
            ], Response::HTTP_CREATED);
        } catch (\Throwable $th) {
            return response()->json([
                'error' => $th->getMessage()
            ], Response::HTTP_BAD_REQUEST);
        }
    }

    public function listar() {
        try {
            $antecedentes =  $this->antecedentesSexualesRepository->listarAntecedentes();
            return response()->json($antecedentes);
        } catch (\Throwable $th) {
            return response()->json([
                'mensaje' => 'error al consultar los antecedentes sexuales'
            ], Response::HTTP_BAD_REQUEST);
        }
    }
}
