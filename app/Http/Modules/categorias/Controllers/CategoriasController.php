<?php

namespace App\Http\Modules\categorias\Controllers;


use Illuminate\Http\Response;
use Illuminate\Http\JsonResponse;
use App\Http\Controllers\Controller;
use App\Http\Modules\categorias\Requests\CrearCategoriasRequest;
use App\Http\Modules\categorias\Repositories\categoriasRepository;
use Illuminate\Http\Request;


class CategoriasController extends Controller
{

    private $categoriasRepository;

    public function __construct()
    {
        $this->categoriasRepository = new categoriasRepository();
    }

    public function listar(Request $request): JsonResponse
    {
        $categoria = $this->categoriasRepository->listar($request);
        try {
            return response()->json([
                'res' => true,
                'data' => $categoria
            ], Response::HTTP_OK);
        } catch (\Throwable $th) {
            return response()->json([
                'res' => false,
                'mensaje' => 'Error al listar las categorias padre',
            ], Response::HTTP_BAD_REQUEST);
        }
    }

    public function crear(CrearCategoriasRequest $request): JsonResponse
    {
        try {
            $categoria = $this->categoriasRepository->crear($request->validated());
            return response()->json($categoria, Response::HTTP_CREATED);
        } catch (\Throwable $th) {
            return response()->json($th->getMessage(), Response::HTTP_BAD_REQUEST);
        }
    }
}
