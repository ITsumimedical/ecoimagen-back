<?php

namespace App\Http\Modules\ImagenesInicio\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Http\Controllers\Controller;
use App\Http\Modules\ImagenesInicio\Requests\CrearImagenesInicioRequest;
use App\Http\Modules\ImagenesInicio\Repositories\ImagenesInicioRepository;
use App\Http\Modules\ImagenesInicio\Requests\CambiarEstadoImagenRequest;
use App\Http\Modules\ImagenesInicio\Services\ImagenesInicioService;
use Illuminate\Http\JsonResponse;

class ImagenesInicioController extends Controller
{
    public function __construct(
        private ImagenesInicioRepository $imagenesRepository,
        protected ImagenesInicioService $imagenesInicioService
    ) {}
  
  /**
   * crearImagen - crea una imagen para las piezas informativas
   *
   * @param  mixed $request
   * @return JsonResponse
   */
  public function crearImagen(CrearImagenesInicioRequest $request): JsonResponse
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
    public function cambiarEstadoImagen(CambiarEstadoImagenRequest $request)
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
