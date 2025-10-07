<?php

namespace App\Http\Modules\AreaClinica\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Modules\AreaClinica\Models\AreaClinica;
use App\Http\Modules\AreaClinica\Repository\AreaClinicaRepository;
use App\Http\Modules\AreaClinica\Requests\ActualizarAreaClinicaRequest;
use App\Http\Modules\AreaClinica\Requests\GuardarAreaClinicaRequest;
use Illuminate\Http\Request;

class AreaClinicaController extends Controller
{
    private $repository;
    private $service;

    public function __construct(){
        /** Inicializar los atributos, Repository y Services */
        $this->repository = new AreaClinicaRepository();
    }

    /**
     * lista las areas de la clinica
     * @param Request $request
     * @return Response
     * @author David Peláez
     */
    public function listar(Request $request){
        try {
            $areas = $this->repository->listar($request);
            return response()->json($areas, 200);
        } catch (\Throwable $th) {
            return response()->json($th->getMessage(), 400);
        }
    }

    /**
     * Guarda un area de la clinica
     * @param Request $request
     * @return Response
     * @author David Peláez
     */
    public function guardar(GuardarAreaClinicaRequest $request){
        try {
            $area = $this->repository->guardar($request->validated());
            return response()->json($area, 201);
        } catch (\Throwable $th) {
            return response()->json($th->getMessage(), 400);
        }
    }

    /**
     * Actualiza un area de la clinica
     * @param Request $request
     * @param AreaClinica
     * @return Response
     * @author David Peláez
     */
    public function actualizar(ActualizarAreaClinicaRequest $request, AreaClinica $area){
        try {
            $this->repository->actualizar($area, $request->validated());
            return response()->json($area, 200);
        } catch (\Throwable $th) {
            return response()->json($th->getMessage(), 400);
        }
    }

     /**
     * Consulta una area clinica en particular
     * @param Request $request
     * @return Response
     * @author JDSS
     */
    public function consultar(AreaClinica $area){
        try {
            return response()->json($area);
        } catch (\Throwable $th) {
            return response()->json($th->getMessage(), 400);
        }
    }

}
