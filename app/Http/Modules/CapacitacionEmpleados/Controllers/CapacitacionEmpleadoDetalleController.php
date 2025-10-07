<?php

namespace App\Http\Modules\CapacitacionEmpleados\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Http\JsonResponse;
use App\Http\Controllers\Controller;
use App\Http\Modules\CapacitacionEmpleados\Models\CapacitacionEmpleadoDetalle;
use App\Http\Modules\CapacitacionEmpleados\Requests\CrearCapacitacionEmpleadoDetalleRequest;
use App\Http\Modules\CapacitacionEmpleados\Repositories\CapacitacionEmpleadoDetalleRepository;
use App\Http\Modules\CapacitacionEmpleados\Requests\ActualizarCapacitacionEmpleadoDetalleRequest;

class CapacitacionEmpleadoDetalleController extends Controller
{
    private $capacitacionDetalleRepository;

    public function __construct(){
        $this->capacitacionDetalleRepository = new CapacitacionEmpleadoDetalleRepository;
    }

    /**
     * lista los detalles de una capacitación según su id
     * @param Request $request
     * @return Response
     * @author leon
     */
    public function listar(Request $request, $id )
    {
        try {
            $capacitacionDetalle = $this->capacitacionDetalleRepository->listarCapacitacionDetalle($request, $id);
            return response()->json([
                'res' => true,
                'data' => $capacitacionDetalle
            ], Response::HTTP_OK);
        } catch (\Throwable $th) {
            return response()->json([
                'res' => false,
                'mensaje' => 'Error al recuperar los detalles de las capacitaciones',
            ], Response::HTTP_BAD_REQUEST);
        }
    }

    /**
     * Guarda un detalle sobre una capacitación
     * @param Request $request
     * @return Response
     * @author leon
     */
    public function crear(CrearCapacitacionEmpleadoDetalleRequest $request):JsonResponse
    {
        try {
            $nuevoDetalle = new CapacitacionEmpleadoDetalle($request->all());
            $capacitacionDetalle = $this->capacitacionDetalleRepository->guardar($nuevoDetalle);
            return response()->json([
                'res' => true,
                'data' => $capacitacionDetalle,
                'mensaje' => 'Detalle creado con exito!.',
            ], Response::HTTP_CREATED);
        } catch (\Throwable $th) {
            return response()->json([
                'res' => false,
                'mensaje' => 'Error al crear detalle',
            ], Response::HTTP_BAD_REQUEST);
        }
    }

    /**
     * Actualiza un detalle de una capacitación
     * @param Request $request
     * @return Response
     * @author leon
     */
    public function actualizar(ActualizarCapacitacionEmpleadoDetalleRequest $request, int $id): JsonResponse
    {
        try {
            $capacitacionDetalle = $this->capacitacionDetalleRepository->buscar($id);
            $capacitacionDetalle->fill($request->all());

            $actualizaCapacitacionDetalle = $this->capacitacionDetalleRepository->guardar($capacitacionDetalle);

            return response()->json([
                'res' => true,
                'data' => $actualizaCapacitacionDetalle,
                'mensaje' => 'detalle actualizado con exito!.'
            ], Response::HTTP_OK);

        } catch (\Throwable $th) {
            return response()->json([
                'res' => false,
                'error' => $th->getMessage(),
                'mensaje' => 'Error al actualizar el detalle'
            ], Response::HTTP_BAD_REQUEST);
        }
    }
}
