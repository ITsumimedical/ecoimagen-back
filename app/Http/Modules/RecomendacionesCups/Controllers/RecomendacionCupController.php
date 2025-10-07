<?php

namespace App\Http\Modules\RecomendacionesCups\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Http\JsonResponse;
use App\Http\Controllers\Controller;
use App\Http\Modules\RecomendacionesCups\Repositories\RecomendacionCupRepository;
use App\Http\Modules\RecomendacionesCups\Requests\CrearRecomendacionCupRequest;

class RecomendacionCupController extends Controller
{
   public function __construct(private RecomendacionCupRepository $recomendacionCupRepository) {

   }

   /**
     * listar
     *
     * @param  string $request
     * @return JsonResponse
     * @author jdss
     */

     public function listar(Request $request): JsonResponse
    {
        try {
            $proyecto = $this->recomendacionCupRepository->listar($request);
            return response()->json( $proyecto, Response::HTTP_OK);
        } catch (\Throwable $th) {
            return response()->json([
                'mensaje' => 'Error al listar los proyectos de la empresa',
            ], Response::HTTP_BAD_REQUEST);
        }
    }

    public function crear(CrearRecomendacionCupRequest $request){
        try {
            $referencia = $this->recomendacionCupRepository->crear($request->validated());
            return response()->json([
                 $referencia
            ], Response::HTTP_OK);
        } catch (\Throwable $th) {
            return response()->json(Response::HTTP_BAD_REQUEST);
        }
    }



    /**
     * actualiza una recomendacion
     *
     * @param  mixed $request
     * @param  mixed $id
     * @return JsonResponse
     */
    public function actualizar(Request $request, int $id): JsonResponse
    {
        try {
            $recomendacion = $this->recomendacionCupRepository->buscar($id);
            $recomendacion->fill($request->all());
            $actualizarRol = $this->recomendacionCupRepository->guardar($recomendacion);
            return response()->json([$actualizarRol], Response::HTTP_OK);
        } catch (\Throwable $th) {
            return response()->json(['mensaje' => 'Error al actualizar recomendación'],
             Response::HTTP_BAD_REQUEST);
        }
    }


    /**
     * actualiza una recomendacion
     *
     * @param  mixed $request
     * @param  mixed $id
     * @return JsonResponse
     */
    public function consultar(Request $request): JsonResponse
    {
        try {
            $recomendacion = $this->recomendacionCupRepository->consultarRecomendacion($request->all());

            return response()->json($recomendacion, Response::HTTP_OK);
        } catch (\Throwable $th) {
            return response()->json(['mensaje' => 'Error al consultar'],
             Response::HTTP_BAD_REQUEST);
        }
    }

     /**
     * actualiza el estado de una recomendacion
     *
     * @param  mixed $request
     * @param  mixed $id
     * @return JsonResponse
     */
    public function cambiarEstado(Request $request,int $id): JsonResponse
    {
        try {
            $recomendacion = $this->recomendacionCupRepository->cambiarEstado($request->all(),$id);

            return response()->json($recomendacion, Response::HTTP_OK);
        } catch (\Throwable $th) {
            return response()->json(['mensaje' => 'Error al consultar'],
             Response::HTTP_BAD_REQUEST);
        }
    }
}
