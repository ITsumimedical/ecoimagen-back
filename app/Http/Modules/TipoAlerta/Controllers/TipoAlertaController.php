<?php

namespace App\Http\Modules\TipoAlerta\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Http\Controllers\Controller;
use App\Http\Modules\TipoAlerta\Repositories\TipoAlertaRepository;
use App\Http\Modules\TipoAlerta\Requests\CrearTipoAlertaRequest;

class TipoAlertaController extends Controller
{
    public function __construct(protected TipoAlertaRepository $tipoAlertaRepository){

    }


    public function listar(Request $request){
        try{
            $tipo = $this->tipoAlertaRepository->listarTipo($request);
            return response()->json($tipo, 200);
        }catch(\Throwable $th){
            return response()->json([
                'mensaje' => 'Error al listar la información',
                'error' => $th->getMessage(),
            ], Response::HTTP_BAD_REQUEST);
        }
    }


    public function crear(CrearTipoAlertaRequest $request){
        try{
             $this->tipoAlertaRepository->crear($request->validated());
            return response()->json(['mensaje' => 'Se creo exitosamente'], 201);
        }catch(\Throwable $th){
            return response()->json([
                'mensaje' => 'Error al crear el mensaje',
                'error' => $th->getMessage(),
            ], Response::HTTP_BAD_REQUEST);
        }
    }

    /**
     * Actualiza una familia
     * @param Request $request
     * @param CupsFamilia $familia
     * @return Response
     * @author David Peláez
     */
    public function actualizar(Request $request, int $id){

        try {
            $mensaje = $this->tipoAlertaRepository->buscar($id);
            $mensaje->fill($request->all());
            $this->tipoAlertaRepository->guardar($mensaje);
            return Response()->json([
                'mensaje' => 'Categoria de mesa de ayuda actualizada con éxito'
            ], Response::HTTP_OK);
        } catch (\Throwable $th) {
            return response()->json([
                $th->getMessage(),
                'mensaje' => 'Error al actualizar la categoria mesa de ayudas'
            ], Response::HTTP_BAD_REQUEST);
        }

    }

    public function cambiarEstado($tipo_id)
    {
        try{
            $this->tipoAlertaRepository->cambiarEstado($tipo_id);
            return response()->json(['mensaje' => 'Se actualizo exitosamente'], 200);
        }catch(\Throwable $th){
            return response()->json([
                'mensaje' => 'Error al actualizar la información',
                'error' => $th->getMessage(),
            ], Response::HTTP_BAD_REQUEST);
        }
    }
}
