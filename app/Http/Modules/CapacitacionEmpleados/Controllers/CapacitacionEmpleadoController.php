<?php

namespace App\Http\Modules\CapacitacionEmpleados\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Http\JsonResponse;
use App\Http\Controllers\Controller;
use App\Http\Modules\CapacitacionEmpleados\Models\CapacitacionEmpleado;
use App\Http\Modules\CapacitacionEmpleados\Requests\CrearCapacitacionEmpleadoRequest;
use App\Http\Modules\CapacitacionEmpleados\Repositories\CapacitacionEmpleadoRepository;
use App\Http\Modules\CapacitacionEmpleados\Requests\ActualizarCapacitacionEmpleadoRequest;

class CapacitacionEmpleadoController extends Controller
{
    private $capacitacionEmpleadoRepository;

    public function __construct(){
        $this->capacitacionEmpleadoRepository = new CapacitacionEmpleadoRepository;
    }

    /**
     * lista las capacitaciones de los empleados
     * @param Request $request
     * @return Response
     * @author leon
     */
    public function listar(Request $request)
    {
        try {
            $capacitacionEmpleado = $this->capacitacionEmpleadoRepository->listar($request);
            return response()->json([
                'res' => true,
                'data' => $capacitacionEmpleado
            ], Response::HTTP_OK);
        } catch (\Throwable $th) {
            return response()->json([
                'res' => false,
                'mensaje' => 'Error al recuperar las capacitaciones de los empleados',
            ], Response::HTTP_BAD_REQUEST);
        }
    }

    /**
     * Guarda una capacitación de un empelado
     * @param Request $request
     * @return Response
     * @author leon
     */
    public function crear(CrearCapacitacionEmpleadoRequest $request):JsonResponse
    {
        try {
            $nuevaCapacitacionEmpleado = new CapacitacionEmpleado($request->all());
            $capacitacionEmpleado = $this->capacitacionEmpleadoRepository->guardar($nuevaCapacitacionEmpleado);
            return response()->json([
                'res' => true,
                'data' => $capacitacionEmpleado,
                'mensaje' => 'Capacitación creada con exito!.',
            ], Response::HTTP_CREATED);
        } catch (\Throwable $th) {
            return response()->json([
                'res' => false,
                'mensaje' => 'Error al crear la capacitación',
            ], Response::HTTP_BAD_REQUEST);
        }
    }

    /**
     * Actualiza una capacitación de un empleado
     * @param Request $request
     * @return Response
     * @author leon
     */
    public function actualizar(ActualizarCapacitacionEmpleadoRequest $request, int $id): JsonResponse
    {
        try {
            $capacitacionEmpleado = $this->capacitacionEmpleadoRepository->buscar($id);
            $capacitacionEmpleado->fill($request->all());

            $actualizaCapacitacionEmpleado = $this->capacitacionEmpleadoRepository->guardar($capacitacionEmpleado);

            return response()->json([
                'res' => true,
                'data' => $actualizaCapacitacionEmpleado,
                'mensaje' => 'Capacitación actualizado con exito!.'
            ], Response::HTTP_OK);

        } catch (\Throwable $th) {
            return response()->json([
                'res' => false,
                'error' => $th->getMessage(),
                'mensaje' => 'Error al actualizar la capacitación'
            ], Response::HTTP_BAD_REQUEST);
        }
    }
}
