<?php

namespace App\Http\Modules\PqrsfTipoSolicitud\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Http\JsonResponse;
use App\Http\Controllers\Controller;
use App\Http\Modules\PqrsfTipoSolicitud\Repositories\PqrsfTipoSolicitudRepository;
use App\Http\Modules\PqrsfTipoSolicitud\Services\PqrsfTipoSolicitudService;
use App\Http\Modules\PqrsfTipoSolicitud\Requests\CrearPqrsfTipoSolicitudRequest;
use App\Http\Modules\PqrsfTipoSolicitud\Models\PqrsfTipoSolicitud;
use App\Http\Modules\PqrsfTipoSolicitud\Requests\ActualizarPqrsfTipoSolicitudRequest;

class PqrsfTipoSolicitudController extends Controller
{
    protected $tipoSolicitudRepository;
    protected $tipoSolicitudService;

    public function __construct() {
        $this->tipoSolicitudRepository = new PqrsfTipoSolicitudRepository();
        $this->tipoSolicitudService = new PqrsfTipoSolicitudService();
    }


    /**
     * lista de Pqrsf
     * @param Request $request
     * @return Response
     * @author kobatime
     */
    public function listar(Request $request)
    {
        try {

            $TipoSolcitud = $this->tipoSolicitudRepository->listar($request);
            return response()->json([
                'res' => true,
                'data' => $TipoSolcitud
            ], Response::HTTP_OK);
        } catch (\Throwable $th) {
            return response()->json([
                'res' => false,
                'mensaje' => 'Error al listar los tipos de solicitudes',
            ], Response::HTTP_BAD_REQUEST);
        }
    }

    /**
     * Guarda un tipo de solicitud pqrsf
     * @param Request $request
     * @return Response
     * @author kobatime
     */
    public function crear(CrearPqrsfTipoSolicitudRequest $request): JsonResponse
    {
        try {
            // se usa servicio para añadir el usuario quien crear el tipo de solicitud
            $TipoSolcitud = $this->tipoSolicitudService->prepararData($request->validated());
            //se envia la data a repository
            $nuevoTipoSolcitud = $this->tipoSolicitudRepository->crear($TipoSolcitud);
            return response()->json([
                'res' => true,
                'data' => $nuevoTipoSolcitud,
                'mensaje' => 'Se creo el tipo de solicitud con exito!',
            ], Response::HTTP_CREATED);
        } catch (\Throwable $th) {
            return response()->json([
                'res' => false,
                'mensaje' => 'Error al crear el tipo de solicitud!',
            ], Response::HTTP_BAD_REQUEST);
        }
    }

    /**
     * Actualiza estado del tipo de solicitud
     * @param Request $request
     * @param int $id
     * @return Response
     * @author kobatime
     */
    public function actualizar(ActualizarPqrsfTipoSolicitudRequest $request, int $id): JsonResponse
    {
        try {
            // se busca el tipo de solicitud
            $TipoSolcitud = $this->tipoSolicitudRepository->buscar($id);
            // se realiza una comparacion de los datos
            $TipoSolcitud->fill($request->all());
            // se envia los datos al repositorio
            $actualizarTipoSolcitud = $this->tipoSolicitudRepository->guardar($TipoSolcitud);
            return response()->json([
                'res' => true,
                'data' => $actualizarTipoSolcitud,
                'mensaje' => 'El tipo de solicitud fue actualizada con exito!'
            ], Response::HTTP_OK);
        } catch (\Throwable $th) {
            return response()->json([
                'res' => false,
                'mensaje' => 'Error al intentar actualizar el tipo de solicitud!'
            ], Response::HTTP_BAD_REQUEST);
        }
    }
}
