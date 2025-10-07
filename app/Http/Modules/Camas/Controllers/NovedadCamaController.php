<?php

namespace App\Http\Modules\Camas\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use App\Http\Modules\Camas\Repositories\CamaRepository;
use App\Http\Modules\Camas\Requests\CrearNovedadCamaRequest;
use App\Http\Modules\Camas\Repositories\NovedadCamaRepository;

class NovedadCamaController extends Controller
{
    public function __construct(protected NovedadCamaRepository $novedadCamaRepository,
                                protected CamaRepository $camaRepository) {

    }

     /**
     * Creo una novedad
     * @param Request $request
     * @return Response $novedad
     * @author JDSS
     */

     public function crear(CrearNovedadCamaRequest $request){
        try {
            DB::beginTransaction();
            $novedad = $this->novedadCamaRepository->crear($request->validated());
            $this->camaRepository->actualizarCama($request['cama_id'],['estado_id'=>$request['estado']]);
            DB::commit();
            return response()->json($novedad,200);
        } catch (\Throwable $th) {
            DB::rollBack();
            return response()->json([
                'Error' =>  $th->getMessage()
            ],Response::HTTP_BAD_REQUEST );
        }
     }
}
