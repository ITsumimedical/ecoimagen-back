<?php

namespace App\Http\Modules\Codesumis\subgruposTerapeuticos\Controllers;


use Illuminate\Http\Response;
use App\Http\Controllers\Controller;
use App\Http\Modules\Codesumis\subgruposTerapeuticos\Repositories\subgruposTerapeuticosRepository;
use App\Http\Modules\Codesumis\subgruposTerapeuticos\Requests\ActualizarSubgrupoTerapeuticoRequest;
use App\Http\Modules\Codesumis\subgruposTerapeuticos\Requests\CrearsubgruposTerapeuticosRequest;

class subgruposTerapeuticosController extends Controller
{
    private $subgruposRepository;

    public function __construct()
    {
        $this->subgruposRepository = new subgruposTerapeuticosRepository();
    }

    public function listar()
    {
        try {
            $subgrupos = $this->subgruposRepository->listarsubgruposTerapeuticos();
            return response()->json($subgrupos, Response::HTTP_OK);
        } catch (\Throwable $th) {
            return response()->json($th->getMessage(), Response::HTTP_BAD_REQUEST);
        }
    }

    public function crear(CrearsubgruposTerapeuticosRequest $request)
    {
        try {
            $this->subgruposRepository->crear($request->validated());
            return response()->json(['mensaje' => 'Se ha creado el subgrupo terapeutico correctamente.'], Response::HTTP_CREATED);
        } catch (\Throwable $th) {
            return response()->json(['error al crear el subgrupo terapeutico' => $th->getMessage()], 400);
        }
    }

    public function actualizar(ActualizarSubgrupoTerapeuticoRequest $request, $id)
    {
        try {
            $this->subgruposRepository->actualizarSubgrupo($id, $request->validated());
            return response()->json(['mensaje' => 'Se ha actualizado el grupo correctamente.'], Response::HTTP_OK);
        } catch (\Throwable $th) {
            return response()->json(['error al actualizar el grupo' => $th->getMessage()], 400);
        }
    }
}
