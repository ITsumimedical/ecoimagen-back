<?php

namespace App\Http\Modules\Incidentes\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Http\JsonResponse;
use App\Http\Controllers\Controller;
use App\Http\Modules\Incidentes\Models\Incidente;
use App\Http\Modules\Incidentes\Repositories\IncidenteRepository;
use App\Http\Modules\Incidentes\Requests\ActualizarIncidenteRequest;
use App\Http\Modules\Incidentes\Requests\CrearIncidenteRequest;

class IncidenteController extends Controller
{
    private $incidenteRepository;

    public function __construct(){
        $this->incidenteRepository = new IncidenteRepository;
    }

    /**
     * lista los incidentes de un empleado
     * @param Request $request
     * @return Response
     * @author leon
     */
    public function listar(Request $request): JsonResponse
    {
        $incidente = $this->incidenteRepository->listarSeguimiento($request);
        try {
            return response()->json([
                'res' => true,
                'data' => $incidente
            ], Response::HTTP_OK);
        } catch (\Throwable $th) {
            return response()->json([
                'res' => false,
                'mensaje' => 'Error al listar los incidentes',
            ], Response::HTTP_BAD_REQUEST);
        }
    }

    /**
     * Guarda un incidente
     * @param Request $request
     * @return Response
     * @author leon
     */
    public function crear(CrearIncidenteRequest $request):JsonResponse{
        try {
            $incidente = $this->incidenteRepository->crear($request->validated());
            return response()->json($incidente, Response::HTTP_CREATED);
        } catch (\Throwable $th) {
            return response()->json($th->getMessage(), Response::HTTP_BAD_REQUEST);
        }
    }

    /**
     * Actualiza un incidente
     * @param Request $request
     * @return Response
     * @author leon
     */
    public function actualizar(ActualizarIncidenteRequest $request, Incidente $id){
        try {
            $this->incidenteRepository->actualizar($id, $request->validated());
            return response()->json([]);
        } catch (\Throwable $th) {
            return response()->json($th->getMessage(),400);
        }
    }

    /**
     * cerrar - cierra un incidente
     *
     * @param  mixed $incidente
     * @return void
     */
    public function cerrar(Incidente $incidente){
        try {
            $incidente->cerrar();
            return response()->json($incidente, 200);
        }catch(\Throwable $th){
            return response()->json($th->getMessage(),400);
        }
    }
}
