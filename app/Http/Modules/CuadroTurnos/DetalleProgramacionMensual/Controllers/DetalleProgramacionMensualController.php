<?php

namespace App\Http\Modules\CuadroTurnos\DetalleProgramacionMensual\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Http\JsonResponse;
use App\Http\Controllers\Controller;
use App\Http\Modules\CuadroTurnos\DetalleProgramacionMensual\Repositories\DetalleProgramacionMensualRepository;
use App\Http\Modules\CuadroTurnos\DetalleProgramacionMensual\Requests\ActualizarDetalleProgramacionMensualRequest;
use App\Http\Modules\CuadroTurnos\DetalleProgramacionMensual\Requests\CrearDetalleProgramacionMensualRequest;

class DetalleProgramacionMensualController extends Controller
{
    private $detalleProgramacionMensualRepository;

    public function __construct(){
        $this->detalleProgramacionMensualRepository = new DetalleProgramacionMensualRepository;
    }

    /**
     * lista los detalles periodos de las programaciones mensuales
     * @param Request $request
     * @return Response
     * @author leon
     */
    public function listar(Request $request): JsonResponse
    {
        $detalle = $this->detalleProgramacionMensualRepository->listar($request);
        try {
            return response()->json([
                'res' => true,
                'data' => $detalle
            ], Response::HTTP_OK);
        } catch (\Throwable $th) {
            return response()->json([
                'res' => false,
                'mensaje' => 'Error al listar los detalles para periodos de programaciones mensuales',
            ], Response::HTTP_BAD_REQUEST);
        }
    }

    /**
     * Guarda un detalle de programacion
     * @param Request $request
     * @return Response
     * @author leon
     */
    public function crear(CrearDetalleProgramacionMensualRequest $request):JsonResponse{
        try {
            $detalleProgramacion = $this->detalleProgramacionMensualRepository->crear($request->validated());
            return response()->json($detalleProgramacion, Response::HTTP_CREATED);
        } catch (\Throwable $th) {
            return response()->json($th->getMessage(), Response::HTTP_BAD_REQUEST);
        }
    }

    /**
     * Actualiza un detalle periodo de programacion mensual
     * @param Request $request
     * @return Response
     * @author leon
     */
    public function actualizar(ActualizarDetalleProgramacionMensualRequest $request, int $id): JsonResponse
    {
        try {
            $programacionMensual = $this->detalleProgramacionMensualRepository->buscar($id);
            $programacionMensual->fill($request->validate());

            $actualizaProgramacion = $this->detalleProgramacionMensualRepository->guardar($programacionMensual);

            return response()->json([
                'res' => true,
                'data' => $actualizaProgramacion,
                'mensaje' => 'Detalle de periodo programación mensual actualizada con éxito!.'
            ], Response::HTTP_OK);

        } catch (\Throwable $th) {
            return response()->json([
                'res' => false,
                'error' => $th->getMessage(),
                'mensaje' => 'Error al actualizar el detalle del periodo de programación mensual'
            ], Response::HTTP_BAD_REQUEST);
        }
    }
}
