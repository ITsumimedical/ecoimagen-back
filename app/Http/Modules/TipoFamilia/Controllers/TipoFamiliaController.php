<?php

namespace App\Http\Modules\TipoFamilia\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use App\Http\Controllers\Controller;
use App\Http\Modules\TipoFamilia\Models\TipoFamilia;
use App\Http\Modules\TipoFamilia\Repositories\TipoFamiliaRepository;
use App\Http\Modules\TipoFamilia\Requests\ActualizarTipoFamiliaRequest;
use App\Http\Modules\TipoFamilia\Requests\GuardarTipoFamiliaRequest;

class TipoFamiliaController extends Controller
{

    private $repository;

    public function __construct(){
        $this->repository = new TipoFamiliaRepository();
    }

    /**
     * lista los tipo familia
     * @return void
     * @return JsonResponse
     * @author Jonathan Cobaleda
     */
    public function listar(Request $request){
        try {
            $tipos_familias = $this->repository->listar($request);
            return response()->json($tipos_familias);
        } catch (\Throwable $th) {
            return response()->json($th->getMessage(), 400);
        }
    }

    /**
     * guarda un tipo familia
     * @param  mixed $request
     * @return JsonResponse
     * @author Jonathan Cobaleda
     */
    public function guardar(GuardarTipoFamiliaRequest $request): JsonResponse
    {
        try {
            $nuevoTipoFamilia = $this->repository->crear($request->validated());
            return response()->json($nuevoTipoFamilia, 201);
        } catch (\Throwable $th) {
            return response()->json($th->getMessage(), 400);
        }
    }

    /**
     * actualiza un tipo familia
     * @param  $request, $tipoFamilia
     * @return JsonResponse
     * @author JDSS
     */

    public function actualizar(ActualizarTipoFamiliaRequest $request, TipoFamilia $tipoFamilia)
    {
        try {
            $actualizarTipoFamilia = $this->repository->actualizar($tipoFamilia,$request->validated());
            return response()->json($actualizarTipoFamilia,200);
        } catch (\Throwable $th) {
           return response()->json($th->getMessage(), 400);
        }
    }


    /**
     * Consulta un tipo de familia
     * @param TipoFamilia $tipo_familia
     * @return Response
     * @author JDSS
     */
    public function consultar(TipoFamilia $tipo_familia){
        try {
            return response()->json($tipo_familia);
        } catch (\Throwable $th) {
            return response()->json($th->getMessage(), 400);
        }
    }

    /**
     * cambia el estado del tipo de familia
     * @param TipoFamilia $tipo_familia
     * @return JsonResponse
     * @author David Peláez
     */
    public function cambiarEstado(TipoFamilia $tipo_familia){
        try{
            $this->repository->cambiarEstado($tipo_familia);
            return response()->json($tipo_familia);
        }catch(\Throwable $th){
            return response()->json($th->getMessage(), 400);
        }
    }
    
}
