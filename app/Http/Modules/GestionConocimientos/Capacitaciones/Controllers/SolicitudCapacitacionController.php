<?php

namespace App\Http\Modules\GestionConocimientos\Capacitaciones\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Http\JsonResponse;
use App\Http\Controllers\Controller;
use App\Http\Modules\GestionConocimientos\Capacitaciones\Repositories\SolicitudCapacitacionRepository;
use App\Http\Modules\GestionConocimientos\Capacitaciones\Requests\CrearSolicitudCapacitacionRequest;

class SolicitudCapacitacionController extends Controller
{
    private $solicitudCapacitacionRepository;

    public function __construct(){
        $this->solicitudCapacitacionRepository = new SolicitudCapacitacionRepository;
    }

    /**
     * lista las solicitudes de capacitación de gestión del conocimiento
     * @param Request $request
     * @return Response
     * @author leon
     */
    public function listar(Request $request): JsonResponse
    {
        $solicitud = $this->solicitudCapacitacionRepository->listar($request);
        try {
            return response()->json([
                'res' => true,
                'data' => $solicitud
            ], Response::HTTP_OK);
        } catch (\Throwable $th) {
            return response()->json([
                'res' => false,
                'mensaje' => 'Error al listar las solicitudes de capacitación',
            ], Response::HTTP_BAD_REQUEST);
        }
    }

    /**
     * Guarda una solictud de capacitación del módulo gestión conocimiento
     * @param Request $request
     * @return Response
     * @author leon
     */
    public function crear(CrearSolicitudCapacitacionRequest $request):JsonResponse{
        try {
            $solicitud = $this->solicitudCapacitacionRepository->crear($request->validated());
            return response()->json($solicitud, Response::HTTP_CREATED);
        } catch (\Throwable $th) {
            return response()->json($th->getMessage(), Response::HTTP_BAD_REQUEST);
        }
    }

}
