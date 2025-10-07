<?php

namespace App\Http\Modules\Familias\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Modules\Familias\Models\Familia;
use App\Http\Modules\Familias\Repositories\FamiliaRepository;
use App\Http\Modules\Familias\Request\ActualizarFamiliaRequest;
use App\Http\Modules\Familias\Request\GuardarFamiliaRequest;
use App\Http\Modules\Familias\Request\SincronizarCupsRequest;
use App\Http\Modules\Familias\Request\SincronizarFamiliaRequest;
use App\Http\Modules\Tarifas\Models\Tarifa;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class FamiliaController extends Controller
{
    private $repository;

    public function __construct(){
        $this->repository = new FamiliaRepository();
    }

    /**
     * lista las familias
     * @param Request $request
     * @return Response
     * @author David Peláez
     */
    public function listar(Request $request){
        try{
            $familias = $this->repository->listarFamilias($request);
            return response()->json([
                'res' => true,
                'data' => $familias
            ], 200);
        }catch(\Throwable $th){
            return response()->json($th->getMessage(), 400);
        }
    }

    /**
     * guarda una familia
     * @param Request $request
     * @return Response
     * @author David Peláez
     */
    public function crear(GuardarFamiliaRequest $request){
        try{
            $familia = $this->repository->crear($request->validated());
            return response()->json($familia, 201);
        }catch(\Throwable $th){
            DB::rollback();
            return response()->json($th->getMessage(), 400);
        }
    }

    /**
     * Actualiza una familia
     * @param Request $request
     * @param CupsFamilia $familia
     * @return Response
     * @author David Peláez
     */
    public function actualizar(ActualizarFamiliaRequest $request, Familia $familia){
        try{
            $familia = $this->repository->actualizar($familia, $request->validated());
            return response()->json($familia);
        }catch(\Throwable $th){
            return response()->json($th->getMessage(), $th->getCode());
        }
    }

     /**
     * Consulta una familia
     * @param Familia $familia
     * @return Response
     * @author JDSS
     */
    public function consultar(Request $request, $id){
        try {
            $familia = $this->repository->consultar($request->clave, $id, $request->with);
            return response()->json($familia);
        } catch (\Throwable $th) {
            return response()->json($th->getMessage(), 400);
        }
    }

    /**
     * Cambia el estado de una familia de cups
     * @param Familia $familia
     * @return Boolean
     * @author David Peláez
     */
    public function cambiarEstado(Familia $familia){
        try {
            $this->repository->cambiarEstado($familia);
            return response()->json(true);
        } catch (\Throwable $th) {
            return response()->json($th->getMessage(),400);
        }
    }

    /**
     * Sincroniza los cups a una familia
     * @param Request $request
     * @param Familia $familia
     * @return Familia
     * @author David Peláez
     */
    public function sincronizarCups(SincronizarCupsRequest $request, Familia $familia){
        try {
            $familia->cups()->sync($request->cups);
            return response()->json($familia);
        }catch (\Throwable $th) {
            return response()->json($th->getMessage(), 400);
        }
    }

    /**
     * Sincroniza las familias a una tarifa
     * @param Request $request
     * @param $tarifa_id
     * @return $familiaTarifas
     * @author kobatime
     */
    public function sincronizarTarifas(Request $request, $tarifa_id){
        try {
            $familiaTarifas = $this->repository->guardarFamiliaTarifa($tarifa_id, $request);
            return response()->json($familiaTarifas, 201);
        }catch (\Throwable $th) {
            return response()->json($th->getMessage(), 400);
        }
    }

    /**
     * consultar las familias a una tarifa
     * @param $tarifa_id
     * @return $familiaTarifas
     * @author kobatime
     */
    public function listarFamiliaTarifas($tarifa_id)
    {
        try {
            $familiaTarifas = $this->repository->listarFamiliaTarifas($tarifa_id);
            return response()->json($familiaTarifas);
        } catch (\Throwable $th) {
            return response()->json($th->getMessage(), 400);
        }
    }

    public function familiaCups(Request $request){
        try {
            $familiaCups = $this->repository->listarFamiliaCups($request);
            return response()->json($familiaCups,200);
        } catch (\Throwable $th) {
            return response()->json($th->getMessage(), 400);
        }
    }
}
