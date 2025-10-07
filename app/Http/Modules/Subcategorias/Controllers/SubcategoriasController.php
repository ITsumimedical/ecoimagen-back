<?php

namespace App\Http\Modules\Subcategorias\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Http\JsonResponse;
use App\Http\Controllers\Controller;
use App\Http\Modules\Subcategorias\Repositories\subcategoriasRepository;
use App\Http\Modules\Subcategorias\Requests\ActualizarSubcategoriaRequest;
use App\Http\Modules\Subcategorias\Requests\CrearSubcategoriasRequest;

class SubcategoriasController extends Controller
{
    public function __construct(
        private subcategoriasRepository $SubcategoriasRepository,
    ) {}

    public function listar(Request $request)
    {
        try {
            $subcategorias = $this->SubcategoriasRepository->listarSubcategorias($request);
            return response()->json($subcategorias, Response::HTTP_OK);
        } catch (\Throwable $th) {
            return response()->json($th->getMessage(), Response::HTTP_BAD_REQUEST);
        }
    }
    public function listarTodos(Request $request)
    {
        try {
            $subcategorias = $this->SubcategoriasRepository->listarTodos($request);
            return response()->json($subcategorias, Response::HTTP_OK);
        } catch (\Throwable $th) {
            return response()->json($th->getMessage(), Response::HTTP_BAD_REQUEST);
        }
    }


    public function crear(CrearSubcategoriasRequest $request): JsonResponse
    {
        try {
            $subcategoria = $this->SubcategoriasRepository->crear($request->validated());
            return response()->json($subcategoria, Response::HTTP_CREATED);
        } catch (\Throwable $th) {
            return response()->json($th->getMessage(), Response::HTTP_BAD_REQUEST);
        }
    }

    public function actualizar(ActualizarSubcategoriaRequest $request, $id)
    {
        try {
            $this->SubcategoriasRepository->actualizarSubcategoria($id, $request->validated());
            return response()->json([], 200);
        } catch (\Throwable $th) {
            return response()->json(['error' => $th->getMessage()], 400);
        }
    }

    public function cambiarEstado($id): JsonResponse
    {
        try {
            $canal = $this->SubcategoriasRepository->CambiarEstado($id);
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

    /**
     * Obtiene una subcategoría por su ID
     * @param int $subcategoriaId
     * @return JsonResponse
     * @author Thomas
     */
    public function listarPorId(int $subcategoriaId)
    {
        try {
            $subcategoria = $this->SubcategoriasRepository->listarPorId($subcategoriaId);
            return response()->json($subcategoria, Response::HTTP_OK);
        } catch (\Throwable $th) {
            return response()->json(['error' => $th->getMessage()], 400);
        }
    }

    /**
     * Elimina los derechos asignados a una subcategoría
     * @param int $subcategoriaId
     * @param Request $request
     * @return JsonResponse
     * @author Thomas
     */
    public function eliminarDerechosAsignados(int $subcategoriaId, Request $request)
    {
        try {
            $subcategoria = $this->SubcategoriasRepository->eliminarDerechosAsignados($subcategoriaId, $request->all());

            return response()->json($subcategoria, Response::HTTP_OK);
        } catch (\Throwable $th) {
            return response()->json(['error' => $th->getMessage()], 400);
        }
    }

    /**
     * Asigna los derechos a una subcategoría
     * @param int $subcategoriaId
     * @param Request $request
     * @return JsonResponse
     */
    public function asignarDerechos(int $subcategoriaId, Request $request)
    {
        try {
            $subcategoriaId = $this->SubcategoriasRepository->asignarDerechos($subcategoriaId, $request->all());
            return response()->json($subcategoriaId, Response::HTTP_OK);
        } catch (\Throwable $th) {
            return response()->json(['error' => $th->getMessage()], 400);
        }
    }

    /**
     * Obtiene los derechos de una subcategoría por sus IDs, elimina duplicados
     * @param Request $request
     * @return JsonResponse
     * @author Thomas
     */
    public function listarDerechosSubcategorias(Request $request)
    {
        try {
            $derechos = $this->SubcategoriasRepository->listarDerechosSubcategorias($request->all());
            return response()->json($derechos, Response::HTTP_OK);
        } catch (\Throwable $th) {
            return response()->json(['error' => $th->getMessage()], 400);
        }
    }
}
