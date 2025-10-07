<?php

namespace App\Http\Modules\SalarioMinimo\Controllers;

use App\Http\Modules\Contratos\Services\ContratoService;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Modules\SalarioMinimo\Models\SalarioMinimo;
use App\Http\Modules\SalarioMinimo\Repositories\SalarioMinimoRepository;
use App\Http\Modules\SalarioMinimo\Requests\ActualizarSalarioMinimoRequest;
use App\Http\Modules\SalarioMinimo\Requests\CrearSalarioMinimoRequest;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Response;

class SalarioMinimoController extends Controller
{
    private $repository;

    public function __construct(){
        $this->repository = new SalarioMinimoRepository();
    }

    /**
     * lista los salarios
     * @param request $request
     * @return JsonResponse
     * @author kobatime
     */
    public function listar(Request $request){
        try {
            $salario_minimo = $this->repository->listarSalario($request);
            return response()->json($salario_minimo);
        } catch (\Throwable $th) {
            return response()->json($th->getMessage(), 400);
        }
    }

    /**
     * guarda un salario minimo
     * @param  request $request
     * @return JsonResponse
     * @author kobatime
     */
    public function guardar(CrearSalarioMinimoRequest $request): JsonResponse
    {
        try {
            $nuevoSalario = $this->repository->crearSalario($request->validated());
            return response()->json($nuevoSalario, 201);
        } catch (\Throwable $th) {
            return response()->json([
                'mensaje' => 'Error al crear el salario minimo!',
                'error' => $th->getMessage()
            ], Response::HTTP_BAD_REQUEST);
        }
    }

    /**
     * actualiza un valor de salario minimo
     * @param  $request, $salario_minimo_id
     * @return JsonResponse
     * @author kobatime
     */

    public function actualizar(ActualizarSalarioMinimoRequest $request, SalarioMinimo $salario_minimo_id)
    {
        try {
             $this->repository->actualizar($salario_minimo_id,$request->validated());
            return response()->json(['mensaje' => 'Se actualizo el salario minimo!'] ,Response::HTTP_CREATED);
        } catch (\Throwable $th) {
            return response()->json([
                'mensaje' => 'Error al actualizar el salario minimo!',
                'error' => $th->getMessage()
            ], Response::HTTP_BAD_REQUEST);
        }
    }

     /**
     * actualiza un valor de salario minimo
     * @param  $request, $salario_minimo_id
     * @return JsonResponse
     * @author kobatime
     */

     public function actualizarParametros(Request $request, SalarioMinimo $salario_minimo_id)
     {
         try {
             $actualizarValor = $this->repository->parametros($salario_minimo_id,$request->all());
             return response()->json(['mensaje' => 'Se actualizo los parametros'] ,Response::HTTP_CREATED);
         } catch (\Throwable $th) {
             return response()->json([
                 'mensaje' => 'Error al actualizar el salario minimo!',
                 'error' => $th->getMessage()
             ], Response::HTTP_BAD_REQUEST);
         }
     }

     /**
     * actualiza un valor de salario minimo
     * @param  $request, $salario_minimo_id
     * @return JsonResponse
     * @author kobatime
     */

     public function listarParametros(Request $request, SalarioMinimo $salario_minimo_id)
     {
         try {
             $Valor = $this->repository->listarParametros($salario_minimo_id,$request->all());
             return response()->json($Valor ,Response::HTTP_CREATED);
         } catch (\Throwable $th) {
             return response()->json([
                 'mensaje' => 'Error al actualizar el salario minimo!',
                 'error' => $th->getMessage()
             ], Response::HTTP_BAD_REQUEST);
         }
     }




}
