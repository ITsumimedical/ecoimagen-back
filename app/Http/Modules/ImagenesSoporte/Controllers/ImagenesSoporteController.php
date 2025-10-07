<?php

namespace App\Http\Modules\ImagenesSoporte\Controllers;

use App\Http\Controllers\Controller;

use App\Http\Modules\ImagenesSoporte\Repositories\ImagenesSoporteRepository;
use App\Http\Modules\ImagenesSoporte\Requests\CambiarEstadoImagenServicioRequest;
use App\Http\Modules\ImagenesSoporte\Requests\CrearImagenServicioRequest;
use App\Http\Modules\ImagenesSoporte\Services\ImagenesSoporteService;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Http\JsonResponse;

class ImagenesSoporteController extends Controller
{
   public function __construct(
        private ImagenesSoporteRepository $imagenesRepository,
        private ImagenesSoporteService $imagenesInicioService
    ) {}

  /**
   * crearImagen - crea una imagen para las piezas informativas
   *
   * @param  mixed $request
   * @return JsonResponse
   */
  public function crearImagen(CrearImagenServicioRequest $request): JsonResponse
    {
        try {
            $imagen = $this->imagenesInicioService->crearImagen($request->validated());
            return response()->json($imagen, Response::HTTP_OK);
        } catch (\Throwable $th) {
            return response()->json(
                ['error' => $th->getMessage()],
                Response::HTTP_BAD_REQUEST
            );
        }
    }

    public function listarTodos()
    {
        try {
            $imagenes = $this->imagenesRepository->listarTodos();
            return response()->json($imagenes);
        } catch (\Throwable $th) {
            return response()->json([
                'error' => $th->getMessage()
            ], Response::HTTP_BAD_REQUEST);
        }
    }

   public function listarActivos(): JsonResponse
    {
        try {
            $imagenes = $this->imagenesInicioService->listarActivos();
            return response()->json($imagenes);
        } catch (\Throwable $th) {
            return response()->json(
                ['error' => $th->getMessage()],
                Response::HTTP_BAD_REQUEST
            );
        }
    }

    /**
     * cambiarEstadoImagen - Cambia el estado de una imagen acorde a su id
     *
     * @param  mixed $request
     * @return void
     */
    public function cambiarEstadoImagen(CambiarEstadoImagenServicioRequest $request)
    {
        try {
            $this->imagenesInicioService->cambiarEstadoImagen($request->validated());
            return response()->json($request->id, 200);
        } catch (\Throwable $th) {
            return response()->json([
                'error' => $th->getMessage()
            ], Response::HTTP_BAD_REQUEST);
        }
    }

    /**
     * eliminarImagen - Elimina una imagen por id
     *
     * @param  mixed $id
     * @return void
     */
    public function eliminarImagen(int $id)
    {
        try {
         $imagen = $this->imagenesInicioService->eliminarImagen($id);
            return response()->json($imagen,200);
        } catch (\Throwable $th) {
            return response()->json([
                'error' => $th->getMessage()
            ], Response::HTTP_BAD_REQUEST);
        }
    }
}
