<?php

namespace App\Http\Modules\Incidentes\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Http\JsonResponse;
use App\Http\Controllers\Controller;
use App\Http\Modules\Incidentes\Models\Incidente;
use App\Http\Modules\Incidentes\Repositories\SeguimientoIncidenteRepository;
use App\Http\Modules\Incidentes\Requests\CrearSeguimientoIncidenteRequest;

class SeguimientoIncidenteController extends Controller
{
    private $seguimientoIncidenteRepository;

    public function __construct(){
        $this->seguimientoIncidenteRepository = new SeguimientoIncidenteRepository;
    }

    /**
     * lista los incidentes de un empleado
     * @param Request $request
     * @return Response
     * @author leon
     */
    public function listar(Request $request, $id)
    {
        try {
            $seguimiento = $this->seguimientoIncidenteRepository->listarConEmpleado($id);
            return response()->json([
                'res' => true,
                'data' => $seguimiento
            ], Response::HTTP_OK);
        } catch (\Throwable $th) {
            return response()->json([
                'res' => false,
                'mensajes' => $th->getMessage(),
                'mensaje' => 'Error al recuperar los seguimientos del incidente',
            ], Response::HTTP_BAD_REQUEST);
        }
    }

    /**
     * Guarda un seguimiento de un incidente
     * @param Request $request
     * @return Response
     * @author leon
     */
    public function crear(CrearSeguimientoIncidenteRequest $request):JsonResponse{
        try {
            $seguimientoIncidente = $this->seguimientoIncidenteRepository->crear($request->validated());
            return response()->json($seguimientoIncidente, Response::HTTP_CREATED);
        } catch (\Throwable $th) {
            return response()->json($th->getMessage(), Response::HTTP_BAD_REQUEST);
        }
    }
}
