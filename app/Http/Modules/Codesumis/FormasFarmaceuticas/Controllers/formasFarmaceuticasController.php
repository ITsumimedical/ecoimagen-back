<?php

namespace App\Http\Modules\Codesumis\FormasFarmaceuticas\Controllers;


use Illuminate\Http\Response;
use Illuminate\Http\JsonResponse;
use App\Http\Controllers\Controller;
use App\Http\Modules\Codesumis\FormasFarmaceuticas\Repositories\formasFarmaceuticasRepository;
use App\Http\Modules\Codesumis\FormasFarmaceuticas\Requests\ActualizarFormaFarmaceuticaRequest;
use App\Http\Modules\Codesumis\FormasFarmaceuticas\Requests\CrearformasFarmaceuticasRequest;

class formasFarmaceuticasController extends Controller
{
    private $formasFarmaceuticasRepository;

    public function __construct()
    {
        $this->formasFarmaceuticasRepository = new formasFarmaceuticasRepository();
    }

    public function listar()
    {
        try {
            $subgrupos = $this->formasFarmaceuticasRepository->listarFormas();
            return response()->json($subgrupos, Response::HTTP_OK);
        } catch (\Throwable $th) {
            return response()->json($th->getMessage(), Response::HTTP_BAD_REQUEST);
        }
    }


    public function crear(CrearformasFarmaceuticasRequest $request): JsonResponse
    {
        try {
            $formas = $this->formasFarmaceuticasRepository->crear($request->validated());
            return response()->json($formas, Response::HTTP_CREATED);
        } catch (\Throwable $th) {
            return response()->json($th->getMessage(), Response::HTTP_BAD_REQUEST);
        }
    }

    public function actualizar(ActualizarFormaFarmaceuticaRequest $request, $id)
    {
        try {
            $this->formasFarmaceuticasRepository->actualizarForma($id, $request->validated());
            return response()->json(['mensaje' => 'Se ha actualizado la vía de administración correctamente.'], Response::HTTP_OK);
        } catch (\Throwable $th) {
            return response()->json(['error al actualizar la vía de administración' => $th->getMessage()], 400);
        }
    }
}
