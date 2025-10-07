<?php

namespace App\Http\Modules\EstudiosEmpleados\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Http\JsonResponse;
use App\Http\Controllers\Controller;
use App\Http\Modules\EstudiosEmpleados\Models\EstudioEmpleado;
use App\Http\Modules\EstudiosEmpleados\Requests\CrearEstudioEmpleadoRequest;
use App\Http\Modules\EstudiosEmpleados\Repositories\EstudioEmpleadoRepository;
use App\Http\Modules\EstudiosEmpleados\Requests\ActualizarEstudioEmpleadoRequest;

class EstudioEmpleadoController extends Controller
{
    private $estudioEmpleadoRepository;

    public function __construct(){
        $this->estudioEmpleadoRepository = new EstudioEmpleadoRepository;
    }

    /**
     * lista los estudios de un empleado
     * @param Request $request
     * @return Response
     * @author leon
     */
    public function listar(Request $request, $id )
    {
        try {
            $contratoEmpleado = $this->estudioEmpleadoRepository->listarEstudioEmpleado($request, $id);
            return response()->json([
                'res' => true,
                'data' => $contratoEmpleado
            ], Response::HTTP_OK);
        } catch (\Throwable $th) {
            return response()->json([
                'res' => false,
                'mensaje' => 'Error al recuperar los estudios del empleado',
            ], Response::HTTP_BAD_REQUEST);
        }
    }

    /**
     * Guarda un estudio de un empleado
     * @param Request $request
     * @return Response
     * @author leon
     */
    public function crear(CrearEstudioEmpleadoRequest $request):JsonResponse{
        try {
            $estudio = $this->estudioEmpleadoRepository->crear($request->validated());
            return response()->json($estudio, Response::HTTP_CREATED);
        } catch (\Throwable $th) {
            return response()->json($th->getMessage(), Response::HTTP_BAD_REQUEST);
        }
    }

    /**
     * Actualiza un estudio empleado
     * @param Request $request
     * @return Response
     * @author leon
     */
    public function actualizar(ActualizarEstudioEmpleadoRequest $request, EstudioEmpleado $id){
        try {
            $this->estudioEmpleadoRepository->actualizar($id, $request->validated());
            return response()->json([]);
        } catch (\Throwable $th) {
            return response()->json($th->getMessage(),400);
        }
    }
}
