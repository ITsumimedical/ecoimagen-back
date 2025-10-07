<?php

namespace App\Http\Modules\Eventos\Sucesos\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Http\JsonResponse;
use App\Http\Controllers\Controller;
use App\Http\Modules\Eventos\Sucesos\Models\Suceso;
use App\Http\Modules\Eventos\Sucesos\Repositories\SucesoRepository;
use App\Http\Modules\Eventos\Sucesos\Requests\ActualizarSucesoRequest;
use App\Http\Modules\Eventos\Sucesos\Requests\CrearSucesoRequest;

class SucesoController extends Controller
{
    private $sucesoRepository;

    public function __construct(){
        $this->sucesoRepository = new SucesoRepository;
    }

    /**
     * lista los sucesos para eventos
     * @param Request $request
     * @return Response
     * @author leon
     */
    public function listar(Request $request): JsonResponse
    {
        $suceso = $this->sucesoRepository->listar($request);
        try {
            return response()->json([
                'res' => true,
                'data' => $suceso
            ], Response::HTTP_OK);
        } catch (\Throwable $th) {
            return response()->json([
                'res' => false,
                'mensaje' => 'Error al listar los sucesos',
            ], Response::HTTP_BAD_REQUEST);
        }
    }

    /**
     * Guarda un suceso para eventos
     * @param Request $request
     * @return Response
     * @author leon
     */
    public function crear(CrearSucesoRequest $request):JsonResponse{
        try {
            $suceso = $this->sucesoRepository->crear($request->validated());
            return response()->json($suceso, Response::HTTP_CREATED);
        } catch (\Throwable $th) {
            return response()->json($th->getMessage(), Response::HTTP_BAD_REQUEST);
        }
    }

    /**
     * Actualiza un suceso para eventos
     * @param Request $request
     * @return Response
     * @author leon
     */
    public function actualizar(ActualizarSucesoRequest $request, Suceso $id){
        try {
            $this->sucesoRepository->actualizar($id, $request->validated());
            return response()->json([]);
        } catch (\Throwable $th) {
            return response()->json($th->getMessage(),400);
        }
    }
}
