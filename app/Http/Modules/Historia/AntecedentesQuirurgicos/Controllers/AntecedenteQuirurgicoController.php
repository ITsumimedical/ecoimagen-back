<?php

namespace App\Http\Modules\Historia\AntecedentesQuirurgicos\Controllers;

use Illuminate\Http\Response;
use App\Http\Controllers\Controller;
use App\Http\Modules\Historia\AntecedentesQuirurgicos\Requests\AntecedenteQuirurgicoRequest;
use App\Http\Modules\Historia\AntecedentesQuirurgicos\Services\AntecedenteQuirurgicoService;
use App\Http\Modules\Historia\AntecedentesQuirurgicos\Repositories\AntecedenteQuirurgicoRepository;
use Illuminate\Http\Request;

class AntecedenteQuirurgicoController extends Controller
{
    public function __construct(
        protected AntecedenteQuirurgicoRepository $antecedenteQuirurgicoRepository,
        protected AntecedenteQuirurgicoService $antecedenteQuirurgicoService
    ) {
    }

    public function guardar(AntecedenteQuirurgicoRequest $request)
    {
        try {
            $this->antecedenteQuirurgicoService->guardarAntecedentes($request->validated());
            return response()->json([
                'mensaje' => 'Los antecedentes quirurgicos guardados con exito.'
            ], Response::HTTP_CREATED);
        } catch (\Throwable $th) {
            return response()->json([
                'error' => $th->getMessage()
            ], Response::HTTP_BAD_REQUEST);
        }
    }

    public function guardarNotieneAntecedente(Request $request)
    {
        try {
           $notiene = $this->antecedenteQuirurgicoRepository->crear($request->all());
            return response()->json($notiene, Response::HTTP_CREATED);
        } catch (\Throwable $th) {
            return response()->json($th->getMessage());
        }
    }

    public function listar(Request $request)
    {
        try {
            $antecedentes =  $this->antecedenteQuirurgicoRepository->listarAntecedentes($request);
            return response()->json($antecedentes);
        } catch (\Throwable $th) {
            return response()->json([
                'mensaje' => 'error al consultar los antecedentes quirurgicos'
            ], Response::HTTP_BAD_REQUEST);
        }
    }

    public function eliminar(Request $request)
    {
        try {
            $this->antecedenteQuirurgicoService->eliminar($request->id);
            return response()->json([
                'mensaje' => 'Antecedente quirúrgico eliminado con éxito.'
            ], Response::HTTP_OK);
        } catch (\Throwable $th) {
            return response()->json([
                'error' => $th->getMessage()
            ], Response::HTTP_BAD_REQUEST);
        }
    }
}
