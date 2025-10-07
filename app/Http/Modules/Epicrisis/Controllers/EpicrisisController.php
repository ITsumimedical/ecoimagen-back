<?php

namespace App\Http\Modules\Epicrisis\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use App\Http\Modules\Epicrisis\Requests\CrearEpicrisisRequest;
use App\Http\Modules\Epicrisis\Repositories\EpicrisisRepository;
use App\Http\Modules\AdmisionesUrgencias\Repositories\AdmisionesUrgenciaRepository;
use App\Http\Modules\Epicrisis\Requests\ListarEpicrisisRequest;
use App\Http\Modules\Epicrisis\Requests\ListarHistoricoEpicrisisRequest;
use App\Http\Modules\Epicrisis\Requests\ReferenciaRequest;

class EpicrisisController extends Controller
{
    public function __construct(protected EpicrisisRepository $epicrisisRepository,
                                protected AdmisionesUrgenciaRepository $admisionesUrgenciaRepository) {
    }

    /**
     * Creo una epicrisis de urgencias
     * @param Request $request
     * @return Response $evolucion
     * @author JDSS
     */

     public function crear(CrearEpicrisisRequest $request){
        try {
            DB::beginTransaction();
            $evolucion = $this->epicrisisRepository->crear($request->validated());
            $this->admisionesUrgenciaRepository->actualizarFinalizar($request->admision_urgencia_id);
            DB::commit();
            return response()->json($evolucion);
        } catch (\Throwable $th) {
            DB::rollBack();
            return response()->json([
                'Error' =>  $th->getMessage()
            ], 500);
        }
     }

      /**
     * lista una epicrisis de urgencias
     * @param Request $request
     * @return Response $evolucion
     * @author JDSS
     */

     public function listar(ListarEpicrisisRequest $request){
        try {

            $evolucion = $this->epicrisisRepository->listarEpicrisis($request->validated());
            return response()->json($evolucion);
        } catch (\Throwable $th) {
            return response()->json([
                'Error' =>  $th->getMessage()
            ], 500);
        }
     }


       /**
     * lista una epicrisis de urgencias por remision
     * @param Request $request
     * @return Response $evolucion
     * @author JDSS
     */

     public function listarRemision(){
        try {

            $evolucion = $this->epicrisisRepository->listarRemision();
            return response()->json($evolucion);
        } catch (\Throwable $th) {
            return response()->json([
                'Error' =>  $th->getMessage()
            ], 500);
        }
     }


     /**
     * Registro la referencia en caso de que sea el motivo remision
     * @param Request $request
     * @return Response $evolucion
     * @author JDSS
     */

     public function registroReferencia(ReferenciaRequest $request){
        try {
            DB::beginTransaction();
            $evolucion = $this->epicrisisRepository->registroReferencia($request->validated());
            $this->admisionesUrgenciaRepository->actualizarReferencia($request->admision_urgencia_id);
            DB::commit();
            return response()->json($evolucion);
        } catch (\Throwable $th) {
            DB::rollBack();
            return response()->json([
                'Error' =>  $th->getMessage()
            ], 500);
        }
     }


        /**
     * lista histprico epicrisis de urgencias por remision
     * @param Request $request
     * @return Response $evolucion
     * @author JDSS
     */

     public function listarHistoricoReferencia(ListarHistoricoEpicrisisRequest $request){
        try {

            $evolucion = $this->epicrisisRepository->listarHistoricoReferencia($request->validated());
            return response()->json($evolucion);
        } catch (\Throwable $th) {
            return response()->json([
                'Error' =>  $th->getMessage()
            ], 500);
        }
     }







}
