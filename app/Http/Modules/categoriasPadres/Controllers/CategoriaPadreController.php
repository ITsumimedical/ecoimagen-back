<?php

namespace App\Http\Modules\categoriasPadres\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Modules\categoriasPadres\Repositories\CategoriaPadreRepository;
use App\Http\Modules\categoriasPadres\Requests\CrearCategoriaPadreRequest;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Response;



class CategoriaPadreController extends Controller
{
    private $categoriaPadreRepository;

    public function __construct()
    {
        $this->categoriaPadreRepository = new CategoriaPadreRepository();
    }

    public function listar(Request $request): JsonResponse
    {
        $categoria = $this->categoriaPadreRepository->listar($request);
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

    public function crear(CrearCategoriaPadreRequest $request):JsonResponse{
        try {
            $categoria = $this->categoriaPadreRepository->crear($request->validated());
            return response()->json($categoria, Response::HTTP_CREATED);
        } catch (\Throwable $th) {
            return response()->json($th->getMessage(), Response::HTTP_BAD_REQUEST);
        }
    }
}
