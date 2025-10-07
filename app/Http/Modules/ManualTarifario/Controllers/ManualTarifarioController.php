<?php

namespace App\Http\Modules\ManualTarifario\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Modules\ManualTarifario\Models\ManualTarifario;
use App\Http\Modules\ManualTarifario\Repositories\ManualTarifarioRepository;
use App\Http\Modules\ManualTarifario\Requests\ActualizarManualTarifarioRequest;
use App\Http\Modules\ManualTarifario\Requests\CrearManualTarifarioRequest;
use App\Http\Modules\ManualTarifario\Services\ManualTarifarioService;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class ManualTarifarioController extends Controller
{
    private $repository;
    private $service;

    public function __construct(){
        /** Inicializar los atributos, Repository y Services */
        $this->repository = new ManualTarifarioRepository();
        $this->service = new ManualTarifarioService();
    }

    /**
     * lista los manuales tarifarios
     * @param Request $request
     * @return Response
     * @author David Peláez
     */
    public function listar(Request $request){
        try {
            $manuales_tarifarios = $this->repository->listar($request);
            return response()->json($manuales_tarifarios);
        } catch (\Throwable $th) {
            return response()->json($th->getMessage(), Response::HTTP_BAD_REQUEST);
        }
    }

    /**
     * Guarda un manual tarifario
     * @param Request $request
     * @return Response
     * @author David Peláez
     */
    public function crear(CrearManualTarifarioRequest $request){
        try {
            $manual_tarifario = $this->repository->crear($request->validated());
            return response()->json($manual_tarifario, 201);
        } catch (\Throwable $th) {
            return response()->json($th->getMessage(), Response::HTTP_BAD_REQUEST);
        }
    }

    /**
     * Actualiza un manual tarifario
     * @param Request $request
     * @param ManualTarifarioRequest $manual_tarifario
     * @return Response
     * @author David Peláez
     */
    public function actualizar(ActualizarManualTarifarioRequest $request, ManualTarifario $manual_tarifario){
        try {
            $manual_tarifario->update($request->validated());
            return response()->json($manual_tarifario);
        } catch (\Throwable $th) {
            return response()->json($th->getMessage(), Response::HTTP_BAD_REQUEST);
        }
    }

    /**
     * Cambia el estado de un  manual tarifario
     * @param Request $request
     * @param ManualTarifarioRequest $manual_tarifario
     * @return Response
     * @author David Peláez
     */
    public function cambiarEstado(Request $request, ManualTarifario $manual_tarifario){
        try{
            $manual_tarifario->update([
                'activo' => !$manual_tarifario->activo
            ]);
            return response()->json($manual_tarifario);
        }catch(\Throwable $th){
            return response()->json($th->getMessage(), Response::HTTP_BAD_REQUEST);
        }
    }

    /**
     * Consulta un  de manual tarifario
     * @param Request $request
     * @param $id
     * @return Response
     * @author David Peláez
     */
    public function consultar(Request $request, $id){
        try {
            $manual_tarifario = ManualTarifario::where('id', $id)->firstOrFail();
            return response()->json($manual_tarifario);
        } catch (\Throwable $th) {
            return response()->json($th->getMessage(), Response::HTTP_BAD_REQUEST);
        }
    }
}
