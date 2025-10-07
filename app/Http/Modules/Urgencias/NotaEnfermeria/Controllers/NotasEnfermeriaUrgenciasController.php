<?php

namespace App\Http\Modules\Urgencias\NotaEnfermeria\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Http\Controllers\Controller;
use App\Http\Modules\Urgencias\NotaEnfermeria\Repositories\NotasEnfermeriaUrgenciasRepository;
use App\Http\Modules\Urgencias\NotaEnfermeria\Requests\ActualizarNotaEnfermeriaRequest;
use App\Http\Modules\Urgencias\NotaEnfermeria\Requests\CrearNotaRequest;
use App\Http\Modules\Urgencias\NotaEnfermeria\Requests\ListarNotaRequest;

class NotasEnfermeriaUrgenciasController extends Controller
{
    public function __construct(protected NotasEnfermeriaUrgenciasRepository $notas_enfermeria_urgencias_repository) {

    }

     /**
     * Creo una nota de enfermeria
     * @param Request $request
     * @return Response $nota
     * @author JDSS
     */

     public function crear(CrearNotaRequest $request){
        // return $request;
        try {
            $nota = $this->notas_enfermeria_urgencias_repository->crear($request->validated());
            return response()->json($nota,200);
        } catch (\Throwable $th) {
            return response()->json([
                'Error' =>  $th->getMessage()
            ],Response::HTTP_BAD_REQUEST );
        }
     }

      /**
     * listo las notas por admision
     * @param Request $request
     * @return Response $nota
     * @author JDSS
     */

     public function listarNota(ListarNotaRequest $request){
        try {
            $nota = $this->notas_enfermeria_urgencias_repository->listarNota($request->validated());
            return response()->json($nota,200);
        } catch (\Throwable $th) {
            return response()->json([
                'Error' =>  $th->getMessage()
            ],Response::HTTP_BAD_REQUEST );
        }
     }

     /**
     * actualiza una nota de enfermeria según su id
     *
     * @param  mixed $request
     * @param  mixed $id
     * @return JsonResponse
     */
    public function actualizar(ActualizarNotaEnfermeriaRequest $request, int $id)
    {
        try {
           $cama = $this->notas_enfermeria_urgencias_repository->actualizarNota($id, $request->validated());
            return response()->json($cama);
        } catch (\Throwable $th) {
            return response()->json($th->getMessage(), 400);
        }
    }
}
