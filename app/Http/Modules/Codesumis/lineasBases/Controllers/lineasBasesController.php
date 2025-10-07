<?php

namespace App\Http\Modules\Codesumis\lineasBases\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Http\JsonResponse;
use App\Http\Controllers\Controller;
use App\Http\Modules\Codesumis\lineasBases\Requests\CrearlineasBasesRequest;
use App\Http\Modules\Codesumis\lineasBases\Repositories\lineasBasesRepository;
use App\Http\Modules\Codesumis\lineasBases\Requests\ActualizarLineasBasesRequest;

class lineasBasesController extends Controller
{
    private $lineasBasesRepository;

    public function __construct()
    {
        $this->lineasBasesRepository = new lineasBasesRepository();
    }

    public function listar()
    {
        try {
            $subgrupos = $this->lineasBasesRepository->listarLineas();
            return response()->json($subgrupos, Response::HTTP_OK);
        } catch (\Throwable $th) {
            return response()->json($th->getMessage(), Response::HTTP_BAD_REQUEST);
        }
    }


    public function crear(CrearlineasBasesRequest $request): JsonResponse
    {
        try {
            $formas = $this->lineasBasesRepository->crear($request->validated());
            return response()->json($formas, Response::HTTP_CREATED);
        } catch (\Throwable $th) {
            return response()->json($th->getMessage(), Response::HTTP_BAD_REQUEST);
        }
    }

    public function actualizar(ActualizarLineasBasesRequest $request, $id)
    {
        try {
            $this->lineasBasesRepository->actualizarLinea($id, $request->validated());
            return response()->json(['mensaje' => 'Se ha actualizado el grupo correctamente.'], Response::HTTP_OK);
        } catch (\Throwable $th) {
            return response()->json(['error al actualizar el grupo' => $th->getMessage()], 400);
        }
    }
}
