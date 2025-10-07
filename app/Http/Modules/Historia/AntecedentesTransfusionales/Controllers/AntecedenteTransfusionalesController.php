<?php

namespace App\Http\Modules\Historia\AntecedentesTransfusionales\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Modules\Historia\AntecedentesTransfusionales\Repositories\AntecedenteTransfusionalRepository;
use App\Http\Modules\Historia\AntecedentesTransfusionales\Requests\AntecedenteTransfusionalRequest;
use App\Http\Modules\Historia\AntecedentesTransfusionales\Services\AntecedentesTransfusionalesService;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class AntecedenteTransfusionalesController extends Controller
{
    public function __construct(
        protected AntecedenteTransfusionalRepository $antecedenteTransfusionalRepository,
        protected AntecedentesTransfusionalesService $antecedentesTransfusionalesService
    ) {
    }

    public function guardar(AntecedenteTransfusionalRequest $request)
    {
        try {
            $this->antecedentesTransfusionalesService->guardarAntecedentes($request->validated());
            return response()->json([
                'mensaje' => 'Los antecedentes transfusionales guardados con exito.'
            ], Response::HTTP_CREATED);
        } catch (\Throwable $th) {
            return response()->json([
                'error' => $th->getMessage()
            ], Response::HTTP_BAD_REQUEST);
        }
    }

    public function listar(Request $request)
    {
        try {
            $antecedentes =  $this->antecedenteTransfusionalRepository->listarAntecedentes($request);
            return response()->json($antecedentes);
        } catch (\Throwable $th) {
            return response()->json([
                'mensaje' => 'error al consultar los antecedentes transfusionales'
            ], Response::HTTP_BAD_REQUEST);
        }
    }

    public function eliminar(Request $request)
    {
        try {
            $this->antecedentesTransfusionalesService->eliminar($request->id);
            return response()->json([
                'mensaje' => 'Antecedente transfusional eliminado con éxito.'
            ], Response::HTTP_OK);
        } catch (\Throwable $th) {
            return response()->json([
                'error' => $th->getMessage()
            ], Response::HTTP_BAD_REQUEST);
        }
    }
}
