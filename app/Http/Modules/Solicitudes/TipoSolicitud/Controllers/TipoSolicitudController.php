<?php

namespace App\Http\Modules\Solicitudes\TipoSolicitud\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Modules\Solicitudes\TipoSolicitud\Repositories\TipoSolicitudRedVitalRepository;
use App\Http\Modules\Solicitudes\TipoSolicitud\Requests\ActualizarTipoSolicitudRequest;
use App\Http\Modules\Solicitudes\TipoSolicitud\Requests\CambiarEstadoTipoSolicitudRequest;
use App\Http\Modules\Solicitudes\TipoSolicitud\Requests\CrearTipoSolicitudRedVitalRequest;
use App\Http\Modules\Solicitudes\TipoSolicitud\Services\TipoSolicitudService;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class TipoSolicitudController extends Controller
{
    public function __construct(private TipoSolicitudRedVitalRepository $tipoSolicitudRedVitalRepository,
                                private TipoSolicitudService $tipoSolicitudService) {

    }

    public function guardarTipoSolicitud(CrearTipoSolicitudRedVitalRequest $request){
        try {
            $this->tipoSolicitudRedVitalRepository->crear($request->validated());
        return response()->json(['message' => 'Tipo de solicitud creada con exito!'], Response::HTTP_CREATED);
        } catch (\Throwable $th) {
            return response()->json(['message' => ' el Tipo de solicitud no se pudo crear'], Response::HTTP_BAD_REQUEST);
        }

    }

    public function listar(Request $request){
        try {
         $tipos =  $this->tipoSolicitudRedVitalRepository->listarTipo($request->all());
            return response()->json($tipos, Response::HTTP_OK);
        } catch (\Throwable $th) {
            return response()->json(['message' => $th->getMessage()], Response::HTTP_BAD_REQUEST);
        }
    }

    public function actualizar(ActualizarTipoSolicitudRequest $request){
        try {
          $this->tipoSolicitudService->actualizar($request->validated());
            return response()->json('Tipo de solicitud actualizada con exito!', Response::HTTP_CREATED);
        } catch (\Throwable $th) {
            return response()->json(['message' => $th->getMessage()], Response::HTTP_BAD_REQUEST);
        }

    }

    public function listarActivos(){
        try {
         $tipos =  $this->tipoSolicitudRedVitalRepository->listarActivo();
            return response()->json($tipos, Response::HTTP_OK);
        } catch (\Throwable $th) {
            return response()->json(['message' => $th->getMessage()], Response::HTTP_BAD_REQUEST);
        }
    }

    public function cambiarEstado(CambiarEstadoTipoSolicitudRequest $request,int $id){
        try {
            $tipoSolicitud = $this->tipoSolicitudRedVitalRepository->cambiarEstado($request->validated(),$id);
            return response()->json($tipoSolicitud, Response::HTTP_OK);
        } catch (\Throwable $th) {
            return response()->json(['Error' => $th->getMessage()], Response::HTTP_BAD_REQUEST);
        }
    }


}
