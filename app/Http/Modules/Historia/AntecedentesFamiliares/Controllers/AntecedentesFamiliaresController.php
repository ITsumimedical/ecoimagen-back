<?php

namespace App\Http\Modules\Historia\AntecedentesFamiliares\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Modules\Historia\AntecedentesFamiliares\Repositories\AntecedentesFamiliaresRepository;
use App\Http\Modules\Historia\AntecedentesFamiliares\Requests\AntecedentesFamiliaresRequest;
use App\Http\Modules\Historia\AntecedentesFamiliares\Services\AntecedentesFamiliaresService;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class AntecedentesFamiliaresController extends Controller
{
    public function __construct(
        protected AntecedentesFamiliaresRepository $antecedentesFamiliaresRepository,
        protected AntecedentesFamiliaresService $antecedentesFamiliaresService
    ) {
    }

    /**
     * guardar
     *Funcion para guardar que el afiliado posee antecedentes familiares
     * @param  mixed $request
     * @return void
     */
    public function guardar(AntecedentesFamiliaresRequest $request)
    {
        try {
            $this->antecedentesFamiliaresService->guardarAntecedentes($request->validated());
            return response()->json([
                'mensaje' => 'Se registran los antecedentes familiares con exito.'
            ], Response::HTTP_CREATED);
        } catch (\Throwable $th) {
            return response()->json([
                'mensaje' => 'Error al registran los antecedentes familiares .'
            ], Response::HTTP_BAD_REQUEST);
        }
    }

    /**
     * guardarNotieneAntecedente
     *Funcion para guadar en el campo no tiene antecedentes que el afiliado no posee antecedentes familiares
     * @param  mixed $request
     * @return void
     */
    public function guardarNotieneAntecedente(Request $request)
    {
        try {
            $noTiene = $this->antecedentesFamiliaresRepository->crear($request->all());
            return response()->json($noTiene, Response::HTTP_CREATED);
        } catch (\Throwable $th) {
            return response()->json($th->getMessage());
        }
    }

    public function listar(Request $request)
    {
        try {
            $antecedentes =  $this->antecedentesFamiliaresRepository->listarAntecedentes($request);
            return response()->json($antecedentes);
        } catch (\Throwable $th) {
            return response()->json([
                'mensaje' => 'error al consultar los antecedentes familiares',
                'erro' => $th->getMessage()
            ], Response::HTTP_BAD_REQUEST);
        }
    }

    public function eliminar(Request $request)
    {
        try {
            $antecedente = $this->antecedentesFamiliaresRepository->eliminar($request);
            return response()->json([
                'mensaje' => 'Se ha eliminado la antecedente familiar correctamente.',
                'data' => $antecedente
            ]);
        } catch (\Throwable $th) {
            return response()->json([
                'mensaje' => 'Error al eliminar la antecedente familiar.',
                'erro' => $th->getMessage()
            ], Response::HTTP_BAD_REQUEST);
        }
    }
}
