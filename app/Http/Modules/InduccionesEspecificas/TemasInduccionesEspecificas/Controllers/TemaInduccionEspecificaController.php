<?php

namespace App\Http\Modules\InduccionesEspecificas\TemasInduccionesEspecificas\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Http\JsonResponse;
use App\Http\Controllers\Controller;
use App\Http\Modules\InduccionesEspecificas\TemasInduccionesEspecificas\Models\TemaInduccionEspecifica;
use App\Http\Modules\InduccionesEspecificas\TemasInduccionesEspecificas\Repositories\TemaInduccionEspecificaRepository;
use App\Http\Modules\InduccionesEspecificas\TemasInduccionesEspecificas\Requests\ActualizarTemaInduccionEspecificaRequest;
use App\Http\Modules\InduccionesEspecificas\TemasInduccionesEspecificas\Requests\CrearTemaInduccionEspecificaRequest;

class TemaInduccionEspecificaController extends Controller
{
    private $temaRepository;

    public function __construct(){
        $this->temaRepository = new TemaInduccionEspecificaRepository;
    }

    /**
     * lista los temas de las inducciones especificas con el nombre de su plantilla
     * @param Request $request
     * @return Response
     * @author leon
     */
    public function listar(Request $request): JsonResponse
    {
        $tema = $this->temaRepository->listarConPlantilla($request);
        try {
            return response()->json([
                'res' => true,
                'data' => $tema
            ], Response::HTTP_OK);
        } catch (\Throwable $th) {
            return response()->json([
                'res' => false,
                'err' => $th->getMessage(),
                'mensaje' => 'Error al listar los temas',
            ], Response::HTTP_BAD_REQUEST);
        }
    }

    /**
     * lista los temas de una inducción específica según el id de la plantilla
     * @param Request $request
     * @return Response
     * @author leon
     */
    public function listarTemaDePlantilla(Request $request, $id)
    {
        try {
            $temaInduccion = $this->temaRepository->listarTemaDePlantilla($request, $id);
            return response()->json([
                'res' => true,
                'data' => $temaInduccion
            ], Response::HTTP_OK);
        } catch (\Throwable $th) {
            return response()->json([
                'res' => false,
                'mensaje' => 'Error al recuperar los temas de la plantilla',
            ], Response::HTTP_BAD_REQUEST);
        }
    }

    /**
     * Guarda un tema para inducciones específicas
     * @param Request $request
     * @return Response
     * @author leon
     */
    public function crear(CrearTemaInduccionEspecificaRequest $request):JsonResponse{
        try {
            $tema = $this->temaRepository->crear($request->validated());
            return response()->json($tema, Response::HTTP_CREATED);
        } catch (\Throwable $th) {
            return response()->json($th->getMessage(), Response::HTTP_BAD_REQUEST);
        }
    }

    /**
     * Actualiza un tema para inducciones específicas
     * @param Request $request
     * @return Response
     * @author leon
     */
    public function actualizar(ActualizarTemaInduccionEspecificaRequest $request, TemaInduccionEspecifica $id){
        try {
            $this->temaRepository->actualizar($id, $request->validated());
            return response()->json([]);
        } catch (\Throwable $th) {
            return response()->json($th->getMessage(),400);
        }
    }
}
