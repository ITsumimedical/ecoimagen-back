<?php

namespace App\Http\Modules\TipoPrestador\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Modules\TipoPrestador\Models\TipoPrestador;
use App\Http\Modules\TipoPrestador\Repositories\TipoPrestadorRepository;
use App\Http\Modules\TipoPrestador\Requests\ActualizarTipoPrestadorRequest;
use App\Http\Modules\TipoPrestador\Requests\CrearTipoPrestadorRequest;

class TipoPrestadorController extends Controller
{
   private $tipoPrestadorRepository;

   public function __construct()
   {
     $this->tipoPrestadorRepository = new TipoPrestadorRepository();
   }

    /**
     * Lista los tipos de prestadores
     * @param Request $request
     * @return Response $tipoPrestador
     * @author JDSS
     */
    public function listar(Request $request){
        try {
            $tipoPrestador = $this->tipoPrestadorRepository->listar($request);
            return response()->json($tipoPrestador,200);
        } catch (\Throwable $th) {
            return response()->json($th->getMessage(),400);
        }
    }

    /**
     * Guarda tipo de prestador
     * @param Request $request
     * @return $tipoPrestador
     * @author JDSS
     */
    public function crear(CrearTipoPrestadorRequest $request){
        try {
            $tipoPrestador = $this->tipoPrestadorRepository->crear($request->validated());
            return response()->json($tipoPrestador, 201);
        } catch (\Throwable $th) {
            return response()->json($th->getMessage(), 400);
        }
    }

    /**
     * Guarda tipo de prestador
     * @param Request $request, $tipoPrestador
     * @return $actualizarTipoPrestador
     * @author JDSS
     */
    public function actualizar(ActualizarTipoPrestadorRequest $request, $id){
        try {
            $tipo_prestador = $this->tipoPrestadorRepository->consultar('id', $id);
            $actualizarTipoPrestador = $this->tipoPrestadorRepository->actualizar($tipo_prestador,$request->validated());
            return response()->json($actualizarTipoPrestador, 200);
        } catch (\Throwable $th) {
            return response()->json($th->getMessage(), 400);
        }
    }

    /**
     * Cambia el estado de un tipo de prestador
     * @param Request $request
     * @param ManualTarifarioRequest $tipo_prestador
     * @return Response
     * @author David Peláez
     */
    public function cambiarEstado(Request $request, TipoPrestador $tipo_prestador){
        try{
            $tipo_prestador->update([
                'activo' => !$tipo_prestador->activo
            ]);
            return response()->json($tipo_prestador);
        }catch(\Throwable $th){
            return response()->json($th->getMessage(), 400);
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
            $tipo_prestador = TipoPrestador::where('id', $id)->firstOrFail();
            return response()->json($tipo_prestador);
        } catch (\Throwable $th) {
            return response()->json($th->getMessage(), 400);
        }
    }

}
