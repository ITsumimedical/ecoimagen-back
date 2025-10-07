<?php

namespace App\Http\Modules\InduccionesEspecificas\PlantillasInduccionesEspecificas\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Http\JsonResponse;
use App\Http\Controllers\Controller;
use App\Http\Modules\InduccionesEspecificas\PlantillasInduccionesEspecificas\Models\PlantillaInduccionEspecifica;
use App\Http\Modules\InduccionesEspecificas\PlantillasInduccionesEspecificas\Repositories\PlantillaInduccionEspecificaRepository;
use App\Http\Modules\InduccionesEspecificas\PlantillasInduccionesEspecificas\Requests\ActualizarPlantillaInduccionEspecificaRequest;
use App\Http\Modules\InduccionesEspecificas\PlantillasInduccionesEspecificas\Requests\CrearPlantillaInduccionEspecificaRequest;

class PlantillaInduccionEspecificaController extends Controller
{
    private $plantillaRepository;

    public function __construct(){
        $this->plantillaRepository = new PlantillaInduccionEspecificaRepository;
    }

    /**
     * lista las plantillas de las inducciones especificas
     * @param Request $request
     * @return Response
     * @author leon
     */
    public function listar(Request $request): JsonResponse
    {
        $plantilla = $this->plantillaRepository->listar($request);
        try {
            return response()->json([
                'res' => true,
                'data' => $plantilla
            ], Response::HTTP_OK);
        } catch (\Throwable $th) {
            return response()->json([
                'res' => false,
                'err' => $th->getMessage(),
                'mensaje' => 'Error al listar las plantillas',
            ], Response::HTTP_BAD_REQUEST);
        }
    }

    /**
     * Guarda una plantilla para inducciones específicas
     * @param Request $request
     * @return Response
     * @author leon
     */
    public function crear(CrearPlantillaInduccionEspecificaRequest $request):JsonResponse{
        try {
            $plantilla = $this->plantillaRepository->crear($request->validated());
            return response()->json($plantilla, Response::HTTP_CREATED);
        } catch (\Throwable $th) {
            return response()->json($th->getMessage(), Response::HTTP_BAD_REQUEST);
        }
    }

    /**
     * Actualiza una plantilla para inducciones específicas
     * @param Request $request
     * @return Response
     * @author leon
     */
    public function actualizar(ActualizarPlantillaInduccionEspecificaRequest $request, PlantillaInduccionEspecifica $id){
        try {
            $this->plantillaRepository->actualizar($id, $request->validated());
            return response()->json([]);
        } catch (\Throwable $th) {
            return response()->json($th->getMessage(),400);
        }
    }
}
