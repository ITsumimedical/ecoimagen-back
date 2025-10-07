<?php

namespace App\Http\Modules\Camas\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Http\Controllers\Controller;
use App\Http\Modules\Camas\Repositories\CamaRepository;
use App\Http\Modules\Camas\Requests\ActualizarCamaRequest;
use App\Http\Modules\Camas\Requests\CrearCamaRequest;
use App\Http\Modules\Camas\Requests\listarCamasSensoRequest;
use App\Http\Modules\Pabellones\Requests\ActualizarEstadoCamaRequest;

class CamaController extends Controller
{
    public function __construct(protected CamaRepository $camaRepository) {
    }

     /**
     * Creo una cama
     * @param Request $request
     * @return Response $cama
     * @author JDSS
     */

     public function crear(CrearCamaRequest $request){
        try {
            $cama = $this->camaRepository->crear($request->validated());
            return response()->json($cama,200);
        } catch (\Throwable $th) {
            return response()->json([
                'Error' =>  $th->getMessage()
            ],Response::HTTP_BAD_REQUEST );
        }
     }

      /**
     * listo una cama
     * @param Request $request
     * @return Response $cama
     * @author JDSS
     */

     public function listar(){
        try {
            $cama = $this->camaRepository->listarCama();
            return response()->json($cama,200);
        } catch (\Throwable $th) {
            return response()->json([
                'Error' =>  $th->getMessage()
            ],Response::HTTP_BAD_REQUEST );
        }
     }

     /**
     * actualiza un cargo según su id
     *
     * @param  mixed $request
     * @param  mixed $id
     * @return JsonResponse
     */
    public function actualizar(ActualizarCamaRequest $request, int $id)
    {
        try {
           $cama = $this->camaRepository->actualizarCama($id, $request->validated());
            return response()->json($cama);
        } catch (\Throwable $th) {
            return response()->json($th->getMessage(), 400);
        }
    }

     /**
     * actualiza a estadi activo o inactivo según su id
     *
     * @param  mixed $request
     * @param  mixed $id
     * @return JsonResponse
     */
    public function cambiarEstado(ActualizarEstadoCamaRequest $request, int $id)
    {
        try {
         $cama = $this->camaRepository->actualizarCama($id, $request->validated());
            return response()->json($cama);
        } catch (\Throwable $th) {
            return response()->json($th->getMessage(), 400);
        }
    }

    public function contadorObservacion(){
        try {
           $cama = $this->camaRepository->contadorObservacion();
           return response()->json($cama,200);
        } catch (\Throwable $th) {
           return response()->json($th->getMessage(),400);
        }
    }

     /**
     * listo una cama
     * @param Request $request
     * @return Response $cama
     * @author JDSS
     */

     public function listarCamaCenso(listarCamasSensoRequest $request){
        try {
            $cama = $this->camaRepository->listarCamaCenso($request->validated());
            return response()->json($cama,200);
        } catch (\Throwable $th) {
            return response()->json([
                'Error' =>  $th->getMessage()
            ],Response::HTTP_BAD_REQUEST );
        }
     }




}
