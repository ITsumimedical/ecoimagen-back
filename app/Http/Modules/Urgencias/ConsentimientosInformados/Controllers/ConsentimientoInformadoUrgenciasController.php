<?php

namespace App\Http\Modules\Urgencias\ConsentimientosInformados\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Http\Controllers\Controller;
use App\Http\Modules\Urgencias\ConsentimientosInformados\ListarConsentimientoRequest;
use App\Http\Modules\Urgencias\ConsentimientosInformados\Repositories\ConsentimientoInformadoUrgenciasRepository;
use App\Http\Modules\Urgencias\ConsentimientosInformados\Requests\ActualizarConsentimientoRequest;
use App\Http\Modules\Urgencias\ConsentimientosInformados\Requests\CrearConsentimientoInformadoRequest;

class ConsentimientoInformadoUrgenciasController extends Controller
{
    public function __construct(protected ConsentimientoInformadoUrgenciasRepository $consentimiento_informado_urgencias_repository) {
    }


    /**
     * Creo un consentimiento
     * @param Request $request
     * @return Response $consentimiento
     * @author JDSS
     */

     public function crear(CrearConsentimientoInformadoRequest $request){
        // return $request;
        try {
            $consentimiento = $this->consentimiento_informado_urgencias_repository->crear($request->validated());
            return response()->json($consentimiento,Response::HTTP_CREATED);
        } catch (\Throwable $th) {
            return response()->json([
                'Error' =>  $th->getMessage()
            ],Response::HTTP_BAD_REQUEST );
        }
     }


     /**
     * listo los consentimientos por admision
     * @param Request $request
     * @return Response $consentimiento
     * @author JDSS
     */

     public function listarConsentimiento(ListarConsentimientoRequest $request){
        try {
            $consentimiento = $this->consentimiento_informado_urgencias_repository->listarConsentimiento($request->validated());
            return response()->json($consentimiento,200);
        } catch (\Throwable $th) {
            return response()->json([
                'Error' =>  $th->getMessage()
            ],Response::HTTP_BAD_REQUEST );
        }
     }

      /**
     * actualiza un consentimiento según su id
     *
     * @param  mixed $request
     * @param  mixed $id
     * @return JsonResponse
     */
    public function actualizar(ActualizarConsentimientoRequest $request, int $id)
    {
        try {
           $cama = $this->consentimiento_informado_urgencias_repository->actualizarConsentimiento($id, $request->validated());
            return response()->json($cama);
        } catch (\Throwable $th) {
            return response()->json($th->getMessage(), 400);
        }
    }
}
