<?php

namespace App\Http\Modules\IncapacidadesEmpleados\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Http\JsonResponse;
use App\Http\Controllers\Controller;
use App\Http\Modules\IncapacidadesEmpleados\Models\IncapacidadEmpleado;
use App\Http\Modules\IncapacidadesEmpleados\Repositories\IncapacidadEmpleadoRepository;
use App\Http\Modules\IncapacidadesEmpleados\Requests\ActualizarIncapacidadEmpleadoRequest;
use App\Http\Modules\IncapacidadesEmpleados\Requests\CrearIncapacidadEmpleadoRequest;

class IncapacidadEmpleadoController extends Controller
{
    private $incapacidadEmpleadoRepository;

    public function __construct(){
        $this->incapacidadEmpleadoRepository = new IncapacidadEmpleadoRepository;
    }

    /**
     * lista las incapacidades de los empleados segun el id de su contrato
     * @param Request $request
     * @return Response
     * @author leon
     */
    public function listar(Request $request, $id )
    {
        $incapacidadEmpleado = $this->incapacidadEmpleadoRepository->listarIncapacidadContrato($request, $id);
        try {
            return response()->json([
                'res' => true,
                'data' => $incapacidadEmpleado
            ], Response::HTTP_OK);
        } catch (\Throwable $th) {
            return response()->json([
                'res' => false,
                'mensaje' => 'Error al recuperar las incapacidades del contrato',
            ], Response::HTTP_BAD_REQUEST);
        }
    }

    public function listarInicial(Request $request, $id )
    {
        $incapacidadEmpleado = $this->incapacidadEmpleadoRepository->listarIncapacidadInicial($request, $id);
        try {
            return response()->json([
                'res' => true,
                'data' => $incapacidadEmpleado
            ], Response::HTTP_OK);
        } catch (\Throwable $th) {
            return response()->json([
                'res' => false,
                'error' => $th->getMessage(),
                'mensaje' => 'Error al recuperar las incapacidades iniciales del contrato',
            ], Response::HTTP_BAD_REQUEST);
        }
    }

    /**
     * Guarda una incapacidad de un empleado sobre un contrato
     * @param Request $request
     * @return Response
     * @author leon
     */
    public function crear(CrearIncapacidadEmpleadoRequest $request):JsonResponse{
        try {
            $incapacidadEmpleado = $this->incapacidadEmpleadoRepository->crear($request->validated());
            return response()->json($incapacidadEmpleado, Response::HTTP_CREATED);
        } catch (\Throwable $th) {
            return response()->json($th->getMessage(), Response::HTTP_BAD_REQUEST);
        }
    }
    /**
     * Actualiza una incapacidad de un contrato de un empleado
     * @param Request $request
     * @return Response
     * @author leon
     */
    public function actualizar(ActualizarIncapacidadEmpleadoRequest $request, IncapacidadEmpleado $id){
        try {
            $this->incapacidadEmpleadoRepository->actualizar($id, $request->validated());
            return response()->json([]);
        } catch (\Throwable $th) {
            return response()->json($th->getMessage(),400);
        }
    }
}
