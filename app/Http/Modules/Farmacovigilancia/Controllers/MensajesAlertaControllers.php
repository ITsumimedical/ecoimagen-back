<?php

namespace App\Http\Modules\Farmacovigilancia\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Modules\Familias\Models\Familia;
use App\Http\Modules\Familias\Repositories\FamiliaRepository;
use App\Http\Modules\Familias\Request\ActualizarFamiliaRequest;
use App\Http\Modules\Familias\Request\GuardarFamiliaRequest;
use App\Http\Modules\Familias\Request\SincronizarCupsRequest;
use App\Http\Modules\Familias\Request\SincronizarFamiliaRequest;
use App\Http\Modules\Farmacovigilancia\Repositories\MensajesAlertaRepository;
use App\Http\Modules\Farmacovigilancia\Request\GuardarMensajesAlertaRequest;
use App\Http\Modules\Tarifas\Models\Tarifa;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\DB;

class MensajesAlertaControllers extends Controller
{
    private $repositoryMensaje;

    public function __construct(){
        $this->repositoryMensaje = new MensajesAlertaRepository();
    }

    /**
     * lista las mensajes
     * @param Request $request
     * @return Response
     * @author kobatime
     */
    public function listar(Request $request){
        try{
            $mensaje = $this->repositoryMensaje->listarMensajes($request);
            return response()->json($mensaje, 200);
        }catch(\Throwable $th){
            return response()->json([
                'mensaje' => 'Error al listar la información',
                'error' => $th->getMessage(),
            ], Response::HTTP_BAD_REQUEST);
        }
    }

    /**
     * guarda una familia
     * @param Request $request
     * @return Response
     * @author David Peláez
     */
    public function crear(GuardarMensajesAlertaRequest $request){
        try{
            $familia = $this->repositoryMensaje->crearMensaje($request->validated());
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
            $mensaje = $this->repositoryMensaje->buscar($id);
            $mensaje->fill($request->all());
            $this->repositoryMensaje->guardar($mensaje);
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

    public function cambiarEstado($mensaje_id)
    {
        try{
            $mensaje = $this->repositoryMensaje->cambiarEstado($mensaje_id);
            return response()->json(['mensaje' => 'Se actualizo exitosamente'], 200);
        }catch(\Throwable $th){
            return response()->json([
                'mensaje' => 'Error al actualizar la información',
                'error' => $th->getMessage(),
            ], Response::HTTP_BAD_REQUEST);
        }
    }


}
