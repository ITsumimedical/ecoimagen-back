<?php

namespace App\Http\Modules\HijosEmpleados\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Http\JsonResponse;
use App\Http\Controllers\Controller;
use App\Http\Modules\HijosEmpleados\Models\HijoEmpleado;
use App\Http\Modules\HijosEmpleados\Repositories\HijoEmpleadoRepository;
use App\Http\Modules\HijosEmpleados\Requests\ActualizarHijoEmpleadoRequest;
use App\Http\Modules\HijosEmpleados\Requests\CrearHijoEmpleadoRequest;

class HijoEmpleadoController extends Controller
{
    private $hijoEmpleadoRepository;

    public function __construct(){
        $this->hijoEmpleadoRepository = new HijoEmpleadoRepository;
    }

    /**
     * lista los hijos de un empleado según su id
     * @param Request $request
     * @return Response
     * @author leon
     */
    public function listar(Request $request, $id )
    {
        try {
            $hijoEmpleado = $this->hijoEmpleadoRepository->listarHijoEmpleado($request, $id);
            return response()->json([
                'res' => true,
                'data' => $hijoEmpleado
            ], Response::HTTP_OK);
        } catch (\Throwable $th) {
            return response()->json([
                'res' => false,
                'mensaje' => 'Error al recuperar los hijos del empleado',
            ], Response::HTTP_BAD_REQUEST);
        }
    }

    /**
     * Guarda un hijo de un empleado
     * @param Request $request
     * @return Response
     * @author leon
     */
    public function crear(CrearHijoEmpleadoRequest $request):JsonResponse{
        try {
            $hijoEmpleado = $this->hijoEmpleadoRepository->crear($request->validated());
            return response()->json($hijoEmpleado, Response::HTTP_CREATED);
        } catch (\Throwable $th) {
            return response()->json($th->getMessage(), Response::HTTP_BAD_REQUEST);
        }
    }

    /**
     * Actualiza un hijo de un empleado según su id
     * @param Request $request
     * @return Response
     * @author leon
     */
    public function actualizar(ActualizarHijoEmpleadoRequest $request, HijoEmpleado $id){
        try {
            $this->hijoEmpleadoRepository->actualizar($id, $request->validated());
            return response()->json([]);
        } catch (\Throwable $th) {
            return response()->json($th->getMessage(),400);
        }
    }
}
