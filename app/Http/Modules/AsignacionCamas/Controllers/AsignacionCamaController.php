<?php

namespace App\Http\Modules\AsignacionCamas\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use App\Http\Modules\AdmisionesUrgencias\Repositories\AdmisionesUrgenciaRepository;
use App\Http\Modules\AsignacionCamas\Repositories\AsignacionCamaRepository;
use App\Http\Modules\AsignacionCamas\Requests\CrearAsignacionRequest;
use App\Http\Modules\Camas\Repositories\CamaRepository;

class AsignacionCamaController extends Controller
{
    public function __construct(protected AsignacionCamaRepository $asignacionCamaRepository,
                                protected AdmisionesUrgenciaRepository $admisionesUrgenciaRepository,
                                protected CamaRepository $camaRepository) {

    }

    /**
     * Creo una asignacion de camas
     * @param Request $request
     * @return Response $evolucion
     * @author JDSS
     */

     public function crear(CrearAsignacionRequest $request){
        try {
            DB::beginTransaction();
            $evolucion = $this->asignacionCamaRepository->crear($request->validated());
            $this->admisionesUrgenciaRepository->actualizarAdmisionGeneral($request->admision_urgencia_id,['estado_id'=>63]);
            $this->camaRepository->actualizarCama($request->cama_id,['estado_id'=>64]);
            DB::commit();
            return response()->json($evolucion);
        } catch (\Throwable $th) {
            DB::rollBack();
            return response()->json([
                'Error' =>  $th->getMessage()
            ], 500);
        }
     }
}
