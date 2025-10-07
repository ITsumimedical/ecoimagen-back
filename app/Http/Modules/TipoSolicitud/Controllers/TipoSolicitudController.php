<?php

namespace App\Http\Modules\TipoSolicitud\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Http\JsonResponse;
use App\Http\Controllers\Controller;
use App\Http\Modules\TipoSolicitud\Models\TipoSolicitude;
use App\Http\Modules\TipoSolicitud\Repositories\TipoSolicitudRepository;
use App\Http\Modules\TipoSolicitud\Requests\ActualizarTipoSolicitudRequest;
use App\Http\Modules\TipoSolicitud\Requests\CrearTipoSolicitudRequest;

class TipoSolicitudController extends Controller
{
    private $TipoSolicitudRepository;
    private $service;

    public function __construct(){
       $this->TipoSolicitudRepository = new TipoSolicitudRepository;
    }

    /**
     * lista los tipos de solicitudes
     * @param Request $request
     * @return Response
     * @author JDSS
     */
    public function listar(Request $request)
    {
        try {
            $tipoSolicitud = $this->TipoSolicitudRepository->listar($request);
            return response()->json($tipoSolicitud, Response::HTTP_OK);
        } catch (\Throwable $th) {
            return response()->json([
                'mensaje' => 'Error al recuperar los tipos de solicitudes',
            ], Response::HTTP_BAD_REQUEST);
        }
    }

    /**
     * Guarda un tipo de solicitud
     * @param Request $request
     * @return Response $tipoSolicitud
     * @author JDSS
     */
    public function crear(CrearTipoSolicitudRequest $request): JsonResponse
    {
        try {
            $nuevoTipoSolicitud = new TipoSolicitude($request->all());
            $tipoSolicitud = $this->TipoSolicitudRepository->guardar($nuevoTipoSolicitud);
            return response()->json([
                'res' => true,
                'data' => $tipoSolicitud,
                'mensaje' => 'Se creo el tipo de solicitud',
            ], Response::HTTP_CREATED);
        } catch (\Throwable $th) {
            return response()->json([
                'res' => false,
                'mensaje' => 'Error al crear !',
            ], Response::HTTP_BAD_REQUEST);
        }
    }

    /**
     * Actualiza un tipo de solicitud
     * @param Request $request
     * @param int $id
     * @return Response $actualizarTipoSolicitud
     * @author JDSS
     */
    public function actualizar(Request $request, int $id): JsonResponse
    {
        try {
            $tipoSolicitud = $this->TipoSolicitudRepository->buscar($id);
            $tipoSolicitud->fill($request->all());
            $actualizarTipoSolicitud = $this->TipoSolicitudRepository->guardar($tipoSolicitud);
            return response()->json([
                'res' => true,
                'data' => $actualizarTipoSolicitud,
                'mensaje' => 'El tipo de solicitud fue actualizado con exito!'
            ], Response::HTTP_OK);
        } catch (\Throwable $th) {
            return response()->json([
                'res' => $th->getMessage(),
                'mensaje' => 'Error al intentar actualizar el tipo de solicitud!'
            ], Response::HTTP_BAD_REQUEST);
        }
    }

    public function listarActivos(Request $request){
        try {
            $tipoSolicitud = $this->TipoSolicitudRepository->listarActivos($request);
            return response()->json([
                'res' => true,
                'data' => $tipoSolicitud
            ], Response::HTTP_OK);
        } catch (\Throwable $th) {
            return response()->json([
                'res' => false,
                'error' => $th->getMessage(),
                'mensaje' => 'Error al recuperar los tipos de solicitudes',
            ], Response::HTTP_BAD_REQUEST);
        }
    }
}
