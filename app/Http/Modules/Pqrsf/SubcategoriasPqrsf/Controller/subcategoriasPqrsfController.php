<?php

namespace App\Http\Modules\Pqrsf\SubcategoriasPqrsf\Controller;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Http\JsonResponse;
use App\Http\Controllers\Controller;
use App\Http\Modules\Pqrsf\SubcategoriasPqrsf\Models\subcategoriasPqrsf;
use App\Http\Modules\Pqrsf\SubcategoriasPqrsf\Repositories\SubcategoriaPqrsfRepository;
use App\Http\Modules\Pqrsf\SubcategoriasPqrsf\Request\ActualizarSubcategoriasPqrsfRequest;
use App\Http\Modules\Pqrsf\SubcategoriasPqrsf\Request\CrearsubcategoriasPqrsfRequest;

use App\Http\Modules\Pqrsf\SubcategoriasPqrsf\Services\SubcategoriaPqrsfService;

class subcategoriasPqrsfController extends Controller
{

    public function __construct(private SubcategoriaPqrsfService $subcategoriaPqrsfService, private SubcategoriaPqrsfRepository $subcategoriaPqrsfRepository) {}
    public function crear(CrearsubcategoriasPqrsfRequest $request): JsonResponse
    {
        try {
            $subcategoriaPqrsf = $this->subcategoriaPqrsfService->crearSub($request->validated());

            return response()->json($subcategoriaPqrsf, Response::HTTP_CREATED);
        } catch (\Throwable $th) {
            return response()->json([
                'res' => false,
                'mensaje' => 'Error al crear la subcategoría de PQRSF!',
                'error' => $th->getMessage()
            ], Response::HTTP_BAD_REQUEST);
        }
    }

    public function listar(Request $request): JsonResponse
    {
        try {
            $subcategoriaPqrsf = $this->subcategoriaPqrsfRepository->listarSub($request);

            return response()->json($subcategoriaPqrsf, Response::HTTP_OK);
        } catch (\Throwable $th) {
            return response()->json([
                'res' => false,
                'mensaje' => 'Error al crear la subcategoría de PQRSF!',
                'error' => $th->getMessage()
            ], Response::HTTP_BAD_REQUEST);
        }
    }

    public function eliminar(Request $request): JsonResponse
    {
        try {
            $subcategoriaPqrsf = $this->subcategoriaPqrsfRepository->eliminar($request);

            return response()->json($subcategoriaPqrsf, Response::HTTP_OK);
        } catch (\Throwable $th) {
            return response()->json([
                'res' => false,
                'mensaje' => 'Error al crear la subcategoría de PQRSF!',
                'error' => $th->getMessage()
            ], Response::HTTP_BAD_REQUEST);
        }
    }

    public function actualizar(Request $request): JsonResponse
    {
        try {
            $subcategoriaPqrsf = $this->subcategoriaPqrsfRepository->actualizarSub($request);

            return response()->json($subcategoriaPqrsf, Response::HTTP_OK);
        } catch (\Throwable $th) {
            return response()->json([
                'res' => false,
                'mensaje' => 'Error al crear la subcategoría de PQRSF!',
                'error' => $th->getMessage()
            ], Response::HTTP_BAD_REQUEST);
        }
    }


    public function actualizarSubcategorias(int $pqrsfId, ActualizarSubcategoriasPqrsfRequest $request): JsonResponse
    {

        try {
            $respuesta = $this->subcategoriaPqrsfRepository->actualizarSubcategorias($pqrsfId, $request->validated());
            return response()->json($respuesta, Response::HTTP_OK);
        } catch (\Throwable $th) {
            return response()->json([
                'res' => false,
                'error' => $th->getMessage(),
            ], Response::HTTP_BAD_REQUEST);
        }
    }
}
