<?php

namespace App\Http\Modules\Urgencias\Oxigeno\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Http\Controllers\Controller;
use App\Http\Modules\Urgencias\Oxigeno\Repositories\OxigenoRepository;
use App\Http\Modules\Urgencias\Oxigeno\Requests\CrearOxigenoRequest;
use App\Http\Modules\Urgencias\Oxigeno\Requests\ListarOxigenoRequest;
use App\Http\Modules\Urgencias\Oxigeno\Requests\modificarOxigenoRequest;

class OxigenoController extends Controller
{
    public function __construct(protected OxigenoRepository $oxigeno_repository) {

    }

    /**
     * Creo registro de oxigeno
     * @param Request $request
     * @return Response $nota
     * @author JDSS
     */

     public function crear(CrearOxigenoRequest $request){
        try {
            $nota = $this->oxigeno_repository->crear($request->validated());
            return response()->json($nota,200);
        } catch (\Throwable $th) {
            return response()->json([
                'Error' =>  $th->getMessage()
            ],Response::HTTP_BAD_REQUEST );
        }
     }

    /**
     * listo los signos vitales por admision
     * @param Request $request
     * @return Response $nota
     * @author JDSS
     */

     public function listarOxigeno(ListarOxigenoRequest $request){
        try {
            $nota = $this->oxigeno_repository->listarOxigeno($request->validated());
            return response()->json($nota,200);
        } catch (\Throwable $th) {
            return response()->json([
                'Error' =>  $th->getMessage()
            ],Response::HTTP_BAD_REQUEST );
        }
     }

     public function actualizar(modificarOxigenoRequest $request, int $id)
     {
        try {
            $signo = $this->oxigeno_repository->actualizarOxigeno($id, $request->validated());
            return response()->json($signo, 200);
        } catch (\Throwable $th) {
            return response()->json([
                'Error' =>  $th->getMessage()
            ],Response::HTTP_BAD_REQUEST );
        }
     }

}
