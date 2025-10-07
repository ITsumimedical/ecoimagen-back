<?php

namespace App\Http\Modules\Urgencias\SignosVitales\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Http\Controllers\Controller;
use App\Http\Modules\Urgencias\SignosVitales\Repositories\SignosVitalesRepository;
use App\Http\Modules\Urgencias\SignosVitales\Requests\actualizarSignoVitalRequest;
use App\Http\Modules\Urgencias\SignosVitales\Requests\CrearSignoVitalRequest;
use App\Http\Modules\Urgencias\SignosVitales\Requests\ListarSignosVitalesRequest;

class SignosVitalesController extends Controller
{
    public function __construct(protected SignosVitalesRepository $signosVitalesRepository) {

    }

    /**
     * Creo un consentimiento
     * @param Request $request
     * @return Response $signo
     * @author JDSS
     */

     public function crear(CrearSignoVitalRequest $request){
        // return $request;
        try {
            $signo = $this->signosVitalesRepository->crear($request->validated());
            return response()->json($signo,200);
        } catch (\Throwable $th) {
            return response()->json([
                'Error' =>  $th->getMessage()
            ],Response::HTTP_BAD_REQUEST );
        }
     }

    /**
     * listo los signos por admision
     * @param Request $request
     * @return Response $signo
     * @author JDSS
     */

     public function listarSignosVitales(ListarSignosVitalesRequest $request){
        try {
            $signo = $this->signosVitalesRepository->listarSignosVitales($request->validated());
            return response()->json($signo,200);
        } catch (\Throwable $th) {
            return response()->json([
                'Error' =>  $th->getMessage()
            ],Response::HTTP_BAD_REQUEST );
        }
     }

     public function actualizar(actualizarSignoVitalRequest $request, int $id)
     {
        try {
            $signo = $this->signosVitalesRepository->actualizarSigno($id, $request->validated());
            return response()->json($signo, 200);
        } catch (\Throwable $th) {
            return response()->json([
                'Error' =>  $th->getMessage()
            ],Response::HTTP_BAD_REQUEST );
        }
     }

}
