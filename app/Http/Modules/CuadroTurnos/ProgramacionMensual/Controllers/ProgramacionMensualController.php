<?php

namespace App\Http\Modules\CuadroTurnos\ProgramacionMensual\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Http\JsonResponse;
use App\Http\Controllers\Controller;
use App\Http\Modules\CuadroTurnos\ProgramacionMensual\Repositories\ProgramacionMensualRepository;
use App\Http\Modules\CuadroTurnos\ProgramacionMensual\Requests\ActualizarProgramacionMensualRequest;
use App\Http\Modules\CuadroTurnos\ProgramacionMensual\Requests\CrearProgramacionMensualRequest;

class ProgramacionMensualController extends Controller
{
    private $programacionMensualRepository;

    public function __construct(){
        $this->programacionMensualRepository = new ProgramacionMensualRepository;
    }

    /**
     * lista los periodos de programación mensual
     * @param Request $request
     * @return Response
     * @author leon
     */
    public function listar(Request $request): JsonResponse
    {
        $programacion = $this->programacionMensualRepository->listarPorEmpleado($request);
        try {
            return response()->json([
                'res' => true,
                'data' => $programacion
            ], Response::HTTP_OK);
        } catch (\Throwable $th) {
            return response()->json([
                'res' => false,
                'mensaje' => 'Error al listar los periodos de programaciones mensuales',
            ], Response::HTTP_BAD_REQUEST);
        }
    }

    /**
     * Guarda un periodo mensual
     * @param Request $request
     * @return Response
     * @author leon
     */
    public function crear(CrearProgramacionMensualRequest $request):JsonResponse{
        try {
            $programacionMensual = $this->programacionMensualRepository->crear($request->validated());
            return response()->json($programacionMensual, Response::HTTP_CREATED);
        } catch (\Throwable $th) {
            return response()->json($th->getMessage(), Response::HTTP_BAD_REQUEST);
        }
    }

    /**
     * Actualiza un un periodo de programacion mensual
     * @param Request $request
     * @return Response
     * @author leon
     */
    public function actualizar(ActualizarProgramacionMensualRequest $request, int $id): JsonResponse
    {
        try {
            $programacion = $this->programacionMensualRepository->buscar($id);
            $programacion->fill($request->validated());

            $actualizaProgramacion = $this->programacionMensualRepository->actualizar($programacion,$request->validated());

            return response()->json([
                'res' => true,
                'data' => $actualizaProgramacion,
                'mensaje' => 'Programación mensual actualizado con éxito!.'
            ], Response::HTTP_OK);

        } catch (\Throwable $th) {
            return response()->json([
                'res' => false,
                'mensaje' => 'Error al actualizar la programacion mensual'
            ], Response::HTTP_BAD_REQUEST);
        }
    }
}
