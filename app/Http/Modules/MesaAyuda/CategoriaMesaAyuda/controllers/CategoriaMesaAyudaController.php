<?php

namespace App\Http\Modules\MesaAyuda\CategoriaMesaAyuda\controllers;

use App\Http\Controllers\Controller;
use App\Http\Modules\MesaAyuda\CategoriaMesaAyuda\Repositories\CategoriaMesaAyudaRepository;
use App\Http\Modules\MesaAyuda\CategoriaMesaAyuda\Requests\ActualizarCategoriaMesaAyuda;
use App\Http\Modules\MesaAyuda\CategoriaMesaAyuda\Requests\CreateCategoriaMesaAyudasRequest;
use App\Http\Modules\MesaAyuda\CategoriaMesaAyuda\Services\CategoriaMesaAyudaService;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Http\JsonResponse;

class CategoriaMesaAyudaController extends Controller
{
    private $CategoriaMesaAyudaRepository;

    public function __construct(
        CategoriaMesaAyudaRepository $CategoriaMesaAyudaRepository,
        private CategoriaMesaAyudaService $categoriaMesaAyudaService
    ) {
        $this->CategoriaMesaAyudaRepository = $CategoriaMesaAyudaRepository;
    }

    /**
     * listar-Lista las categorias de la mesa de ayudas
     *
     * @param  mixed $request
     * @return void
     */
    public function listar(Request $request)
    {
        try {
            $CategoriaMesaAyuda = $this->CategoriaMesaAyudaRepository->listarCategorias();
            return response()->json($CategoriaMesaAyuda, Response::HTTP_OK);
        } catch (\Throwable $th) {
            return response()->json([
                'error' => $th->getMessage(),
                'mensaje' => 'Error al listar la categoria mesa de ayudas!'
            ], Response::HTTP_BAD_REQUEST);
        }
    }
    public function listarTodas(Request $request)
    {
        try {
            $CategoriaMesaAyuda = $this->CategoriaMesaAyudaRepository->listarTodas();
            return response()->json($CategoriaMesaAyuda, Response::HTTP_OK);
        } catch (\Throwable $th) {
            return response()->json([
                'error' => $th->getMessage(),
                'mensaje' => 'Error al listar la categoria mesa de ayudas!'
            ], Response::HTTP_BAD_REQUEST);
        }
    }

    public function listarCategoria_Area($area)
    {
        try {
            $CategoriaMesaAyuda = $this->CategoriaMesaAyudaRepository->listarCategoriaConArea($area);
            return response()->json($CategoriaMesaAyuda, Response::HTTP_OK);
        } catch (\Throwable $th) {
            return response()->json($th->getMessage(), Response::HTTP_BAD_REQUEST);
        }
    }
    /**
     * crear una categoria en la mesa de ayudas
     *
     * @param  mixed $request->nombre, $request->area_th_id
     * @return JsonResponse
     */
    public function crear(Request $request): JsonResponse
    {
        try {
            $CategoriaMesaAyuda = $this->categoriaMesaAyudaService->guardar($request->all());
            return response()->json($CategoriaMesaAyuda, Response::HTTP_CREATED);
        } catch (\Throwable $th) {
            return response()->json([
                'error' => $th->getMessage(),
                'mensaje' => 'Error al crear una categoria de mesa de ayudas'
            ], Response::HTTP_BAD_REQUEST);
        }
    }
    /**
     * actualizar-actualiza una categoria en la mesa de ayudas por medio del id
     *
     * @param  mixed $request
     * @param  mixed $id
     * @return void
     */
    public function actualizar(Request $request, int $id)
    {

        try {
            $CategoriaMesaAyuda = $this->CategoriaMesaAyudaRepository->buscar($id);
            $CategoriaMesaAyuda->fill($request->except(["user_id"]));
            $this->CategoriaMesaAyudaRepository->guardar($CategoriaMesaAyuda);
            $CategoriaMesaAyuda->user()->sync($request->user_id);
            return Response()->json([
                'mensaje' => 'Categoria de mesa de ayuda actualizada con éxito'
            ], Response::HTTP_OK);
        } catch (\Throwable $th) {
            return response()->json([
                $th->getMessage(),
                'mensaje' => 'Error al actualizar la categoria mesa de ayudas'
            ], Response::HTTP_BAD_REQUEST);
        }
    }

    public function cambiarEstado($id): JsonResponse
    {
        try {
            $canal = $this->CategoriaMesaAyudaRepository->CambiarEstado($id);
            if ($canal) {
                return response()->json($canal, Response::HTTP_OK);
            } else {
                return response()->json([
                    'res' => false,
                    'mensaje' => 'Canal no encontrado',
                ], Response::HTTP_NOT_FOUND);
            }
        } catch (\Throwable $th) {
            return response()->json([
                'res' => false,
                'mensaje' => 'Error al cambiar el estado del canal',
            ], Response::HTTP_BAD_REQUEST);
        }
    }
}
