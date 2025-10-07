<?php

namespace App\Http\Modules\Pqrsf\EmpleadosPqrsf\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Http\JsonResponse;
use App\Http\Controllers\Controller;
use App\Http\Modules\Pqrsf\EmpleadosPqrsf\Services\EmpleadoPqrsfService;
use App\Http\Modules\Pqrsf\EmpleadosPqrsf\Repositories\EmpleadosPqrsfRepository;
use App\Http\Modules\Pqrsf\EmpleadosPqrsf\Requests\ActualizarOperadoresPqrsfRequest;

class EmpleadosPqrsfController extends Controller
{
    public function __construct(private EmpleadosPqrsfRepository $empleadosPqrsfRepository, private EmpleadoPqrsfService $empleadoPqrsfService) {}


    public function listarEmpleados(Request $request)
    {
        try {
            $servicios = $this->empleadosPqrsfRepository->listarEmpleados($request);
            return response()->json($servicios, Response::HTTP_OK);
        } catch (\Throwable $th) {
            return response()->json([
                'Mensaje' => $th->getMessage()
            ], Response::HTTP_BAD_REQUEST);
        }
    }

    public function crear(Request $request): JsonResponse
    {
        try {
            $area = $this->empleadoPqrsfService->crearEmpleado($request->all());
            return response()->json($area, Response::HTTP_CREATED);
        } catch (\Throwable $th) {
            return response()->json($th->getMessage(), Response::HTTP_BAD_REQUEST);
        }
    }


    public function eliminar(Request $request)
    {
        try {
            $servicio = $this->empleadosPqrsfRepository->eliminar($request);

            return response()->json($servicio, Response::HTTP_OK);
        } catch (\Throwable $th) {
            return response()->json([
                'res' => false,
                'mensaje' => 'Error al crear la medicmanto de PQRSF!',
                'error' => $th->getMessage()
            ], Response::HTTP_BAD_REQUEST);
        }
    }

    /**
     * Actualiza los operadores de un PQRSF
     * @param int $pqrsfId
     * @param ActualizarOperadoresPqrsfRequest $request
     * @return JsonResponse
     * @author Thomas
     */
    public function actualizarOperadores(int $pqrsfId, ActualizarOperadoresPqrsfRequest  $request): JsonResponse
    {
        try {
            $respuesta = $this->empleadosPqrsfRepository->actualizarOperadores($pqrsfId, $request->validated());
            return response()->json($respuesta, Response::HTTP_OK);
        } catch (\Throwable $th) {
            return response()->json([
                'res' => false,
                'mensaje' => 'Error al actualizar los operadores de PQRSF!',
                'error' => $th->getMessage()
            ], Response::HTTP_BAD_REQUEST);
        }
    }

    public function removerOperador(int $pqrsfId, Request $request): JsonResponse
    {
        try {
            $respuesta = $this->empleadosPqrsfRepository->removerOperador($pqrsfId, $request->all());
            return response()->json($respuesta, Response::HTTP_OK);
        } catch (\Throwable $th) {
            return response()->json([
                'res' => false,
                'mensaje' => 'Error al remover el operador de PQRSF!',
                'error' => $th->getMessage()
            ], Response::HTTP_BAD_REQUEST);
        }
    }
}
