<?php

namespace App\Http\Modules\Pabellones\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Http\Controllers\Controller;
use App\Http\Modules\Pabellones\Repositories\PabellonRepository;
use App\Http\Modules\Pabellones\Requests\ActualizarEstadoPabellonRequest;
use App\Http\Modules\Pabellones\Requests\ActualizarPabellonRequest;
use App\Http\Modules\Pabellones\Requests\CrearPabellonRequest;
use App\Http\Modules\Pabellones\Requests\listarPabellonRequest;

class PabellonesController extends Controller
{
    public function __construct(protected PabellonRepository $pabellonRepository) {
    }

     /**
     * Creo un pabellon
     * @param Request $request
     * @return Response $pabellon
     * @author JDSS
     */

     public function crear(CrearPabellonRequest $request){
        try {
            $pabellon = $this->pabellonRepository->crear($request->validated());
            return response()->json($pabellon,200);
        } catch (\Throwable $th) {
            return response()->json([
                'Error' =>  $th->getMessage()
            ],Response::HTTP_BAD_REQUEST );
        }
     }

     /**
     * listo un pabellon
     * @param Request $request
     * @return Response $pabellon
     * @author JDSS
     */

     public function listar(listarPabellonRequest $request){
        try {
            $pabellon = $this->pabellonRepository->listarPabellon($request->validated());
            return response()->json($pabellon,200);
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
    public function actualizar(ActualizarPabellonRequest $request, int $id)
    {
        try {
            $pabellon =    $this->pabellonRepository->actualizarPabellon($id, $request->validated());
            return response()->json($pabellon);
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
    public function cambiarEstado(ActualizarEstadoPabellonRequest $request, int $id)
    {
        try {
            $pabellon =  $this->pabellonRepository->actualizarPabellon($id, $request->validated());
            return response()->json($pabellon);
        } catch (\Throwable $th) {
            return response()->json($th->getMessage(), 400);
        }
    }

    /**
     * lista los pabellones con sus camas
     *
     * @param  mixed $request
     * @param  mixed $id
     * @return JsonResponse
     */
    public function listarConCama()
    {
        try {
          $pabellon =  $this->pabellonRepository->listarConCama();
            return response()->json($pabellon,200);
        } catch (\Throwable $th) {
            return response()->json($th->getMessage(), 400);
        }
    }
}
