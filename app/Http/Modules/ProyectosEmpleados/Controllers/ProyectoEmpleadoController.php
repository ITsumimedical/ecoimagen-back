<?php

namespace App\Http\Modules\ProyectosEmpleados\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Http\JsonResponse;
use App\Http\Controllers\Controller;
use App\Http\Modules\ProyectosEmpleados\Models\ProyectosEmpleado;
use App\Http\Modules\ProyectosEmpleados\Requests\CrearProyectoEmpleadoRequest;
use App\Http\Modules\ProyectosEmpleados\Repositories\ProyectoEmpleadoRepository;
use App\Http\Modules\ProyectosEmpleados\Requests\ActualizarProyectoEmpleadoRequest;

class ProyectoEmpleadoController extends Controller
{
    private $proyectoRepository;

    public function __construct(ProyectoEmpleadoRepository $proyectoRepository){
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
                'mensaje' => 'Error al crear!',
            ], Response::HTTP_BAD_REQUEST);
        }
    }

    /**
     * actualiza un proyecto de un empleado según su ID
     *
     * @param  mixed $request
     * @param  mixed $id
     * @return void
     */
    public function actualizar(ActualizarProyectoEmpleadoRequest $request, ProyectosEmpleado $id)
    {
        try {
            $proyecto = $this->proyectoRepository->actualizar($id ,$request->validated());
            return response()->json($proyecto,200);
        } catch (\Throwable $th) {
            return response()->json("No se ha podido realizar la actualización", 400);
        }
    }
}
