<?php

namespace App\Http\Modules\Proyectos\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Http\JsonResponse;
use App\Http\Controllers\Controller;
use App\Http\Modules\Proyectos\Models\Proyecto;
use App\Http\Modules\Proyectos\Repositories\ProyectoRepository;
use App\Http\Modules\Proyectos\Requests\ActualizarProyectoRequest;
use App\Http\Modules\Proyectos\Requests\CrearProyectoRequest;

class ProyectoController extends Controller
{
    private $proyectoRepository;

    public function __construct(){
        $this->proyectoRepository = new ProyectoRepository;
    }

    /**
     * lista los proyectos de la empresa
     * @param Request $request
     * @return Response
     * @author leon
     */
    public function listar(Request $request): JsonResponse
    {
        try {
            $proyecto = $this->proyectoRepository->listar($request);
            return response()->json([
                'res' => true,
                'data' => $proyecto
            ], Response::HTTP_OK);
        } catch (\Throwable $th) {
            return response()->json([
                'res' => false,
                'mensaje' => 'Error al listar los proyectos de la empresa',
            ], Response::HTTP_BAD_REQUEST);
        }
    }

    /**
     * Guarda un proyecto
     * @param Request $request
     * @return Response
     * @author leon
     */
    public function crear(CrearProyectoRequest $request):JsonResponse{
        try {
            $proyecto = $this->proyectoRepository->crear($request->validated());
            return response()->json($proyecto, Response::HTTP_CREATED);
        } catch (\Throwable $th) {
            return response()->json($th->getMessage(), Response::HTTP_BAD_REQUEST);
        }
    }

    /**
     * Actualiza un proyecto
     * @param Request $request
     * @return Response
     * @author leon
     */
    public function actualizar(ActualizarProyectoRequest $request, Proyecto $id){
        try {
            $this->proyectoRepository->actualizar($id, $request->validated());
            return response()->json([]);
        } catch (\Throwable $th) {
            return response()->json($th->getMessage(),400);
        }
    }

}
