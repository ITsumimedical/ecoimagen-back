<?php

namespace App\Http\Modules\ProyectoEmpleado\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Http\JsonResponse;
use App\Http\Controllers\Controller;
use App\Http\Modules\ProyectoEmpleado\Requests\CrearProyectoEmpleadoRequest;
use App\Http\Modules\ProyectoEmpleado\Repositories\ProyectoEmpleadosRepository;

class ProyectoEmpleadosController extends Controller
{
    private $proyectoRepository;

    public function __construct(ProyectoEmpleadosRepository $proyectoRepository){
       $this->proyectoRepository = $proyectoRepository;
    }

    /**
     * lista los proyectos para empleados
     *
     * @param  mixed $request
     * @return void
     */
    public function listar(Request $request){
        try {
            $proyecto = $this->proyectoRepository->listar($request);
            return response()->json($proyecto);
        } catch (\Throwable $th) {
            return response()->json($th->getMessage(), 400);
        }
    }

    /**
     * Guarda un proyecto para un empleado
     * @param Request $request
     * @return Response $proyecto
     * @author leon
     */
    public function crear(CrearProyectoEmpleadoRequest $request): JsonResponse
    {
        try {
            $proyecto = $this->proyectoRepository->crear($request->validated());
            return response()->json($proyecto, Response::HTTP_CREATED);
        } catch (\Throwable $th) {
            return response()->json([
                'res' => false,
                'error' => $th->getMessage(),
                'mensaje' => 'Error al crear!',
            ], Response::HTTP_BAD_REQUEST);
        }
    }
}
