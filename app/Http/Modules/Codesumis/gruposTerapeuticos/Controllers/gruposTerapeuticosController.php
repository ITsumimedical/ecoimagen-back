<?php

namespace App\Http\Modules\Codesumis\gruposTerapeuticos\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Modules\Codesumis\gruposTerapeuticos\Repositories\gruposTerapeuticosRepository;
use App\Http\Modules\Codesumis\gruposTerapeuticos\Requests\ActualizarGrupoTerapeuticoRequest;
use App\Http\Modules\Codesumis\gruposTerapeuticos\Requests\CreargruposTerapeuticosRequests;
use Illuminate\Http\Response;
use Illuminate\Http\JsonResponse;

class gruposTerapeuticosController extends Controller
{
    private $gruposTerapeuticosRepository;

    public function __construct()
    {
        $this->gruposTerapeuticosRepository = new gruposTerapeuticosRepository();
    }

    public function listar()
    {
        try {
            $grupos = $this->gruposTerapeuticosRepository->gruposTerapeuticos();
            return response()->json($grupos, Response::HTTP_OK);
        } catch (\Throwable $th) {
            return response()->json($th->getMessage(), Response::HTTP_BAD_REQUEST);
        }
    }

    public function crear(CreargruposTerapeuticosRequests $request): JsonResponse
    {
        try {
            $terapeuticos = $this->gruposTerapeuticosRepository->crear($request->validated());
            return response()->json($terapeuticos, Response::HTTP_CREATED);
        } catch (\Throwable $th) {
            return response()->json($th->getMessage(), Response::HTTP_BAD_REQUEST);
        }
    }

    public function actualizar(ActualizarGrupoTerapeuticoRequest $request, $id)
    {
        try {
            $this->gruposTerapeuticosRepository->actualizarGrupoTerapeutico($id, $request->validated());
            return response()->json(['mensaje' => 'Se ha actualizado el grupo correctamente.'], Response::HTTP_OK);
        } catch (\Throwable $th) {
            return response()->json(['error al actualizar el grupo' => $th->getMessage()], 400);
        }
    }
}
