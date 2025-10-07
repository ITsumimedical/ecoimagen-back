<?php

namespace App\Http\Modules\Eventos\ClasificacionAreas\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Http\JsonResponse;
use App\Http\Controllers\Controller;
use App\Http\Modules\Eventos\ClasificacionAreas\Models\ClasificacionArea;
use App\Http\Modules\Eventos\ClasificacionAreas\Repositories\ClasificacionAreaRepository;
use App\Http\Modules\Eventos\ClasificacionAreas\Requests\ActualizarClasificacionAreaRequest;
use App\Http\Modules\Eventos\ClasificacionAreas\Requests\CrearClasificacionAreaRequest;

class ClasificacionAreaController extends Controller
{
    private $clasificacionAreaRepository;

    public function __construct(){
        $this->clasificacionAreaRepository = new ClasificacionAreaRepository;
    }

    /**
     * lista las clasificaciones de áreas para eventos
     * @param Request $request
     * @return Response
     * @author leon
     */
    public function listar(Request $request): JsonResponse
    {
        $clasificacionArea = $this->clasificacionAreaRepository->listarArea($request->page);
        try {
            return response()->json([
                'res' => true,
                'data' => $clasificacionArea
            ], Response::HTTP_OK);
        } catch (\Throwable $th) {
            return response()->json([
                'res' => false,
                'mensaje' => 'Error al listar las clasificaciones de áreas',
            ], Response::HTTP_BAD_REQUEST);
        }
    }

    public function listarConSuceso(Request $request, $suceso_id )
    {
        try {
            $clasificacion = $this->clasificacionAreaRepository->listarConSuceso($request, $suceso_id);
            return response()->json([
                'res' => true,
                'data' => $clasificacion
            ], Response::HTTP_OK);
        } catch (\Throwable $th) {
            return response()->json([
                'res' => false,
                'mensaje' => 'Error al recuperar las clasificaciones de áreas según su suceso_id',
            ], Response::HTTP_BAD_REQUEST);
        }
    }

    /**
     * Guarda una clasificación de área para eventos
     * @param Request $request
     * @return Response
     * @author leon
     */
    public function crear(CrearClasificacionAreaRequest $request):JsonResponse{
        try {
            $clasificacionArea = $this->clasificacionAreaRepository->crear($request->validated());
            return response()->json($clasificacionArea, Response::HTTP_CREATED);
        } catch (\Throwable $th) {
            return response()->json($th->getMessage(), Response::HTTP_BAD_REQUEST);
        }
    }

    /**
     * Actualiza una clasificación de área para eventos
     * @param Request $request
     * @return Response
     * @author leon
     */
    public function actualizar(ActualizarClasificacionAreaRequest $request, ClasificacionArea $id){
        try {
            $this->clasificacionAreaRepository->actualizar($id, $request->validated());
            return response()->json([]);
        } catch (\Throwable $th) {
            return response()->json($th->getMessage(),400);
        }
    }
}
