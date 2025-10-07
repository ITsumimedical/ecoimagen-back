<?php

namespace App\Http\Modules\GestionPqrsf\ServiciosPqrsf\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Http\Controllers\Controller;
use App\Http\Modules\GestionPqrsf\ServiciosPqrsf\Repositories\ServiciosPqrsfsRepository;
use App\Http\Modules\GestionPqrsf\ServiciosPqrsf\Requests\ActualizarServiciosPqrsfRequest;
use App\Http\Modules\GestionPqrsf\ServiciosPqrsf\Requests\CrearServiciosPqrsfsRequest;
use App\Http\Modules\GestionPqrsf\ServiciosPqrsf\Services\ServiciosPqrsfsService;
use Illuminate\Http\JsonResponse;

class ServiciosPqrsfsController extends Controller
{
    public function __construct(
        private ServiciosPqrsfsRepository $serviciospqrsfRepository,
        private ServiciosPqrsfsService $serviciosService
    ) {}

    public function listarServicios(Request $request)
    {
        try {
            $servicios = $this->serviciospqrsfRepository->listarServicios($request);
            return response()->json($servicios, Response::HTTP_OK);
        } catch (\Throwable $th) {
            return response()->json([
                'Mensaje' => $th->getMessage()
            ], Response::HTTP_BAD_REQUEST);
        }
    }

    /**
     * Crea un nuevo registro de servicios_pqrsf.
     *
     * @param CrearServiciosPqrsfsRequest $request
     * @return JsonResponse
     */
    public function crear(CrearServiciosPqrsfsRequest $request)
    {
        try {
            $this->serviciosService->crearServicio($request->validated());

            return response()->json([
                'message' => 'Se ha creado el servicio correctamente.',
            ], Response::HTTP_CREATED);
        } catch (\Throwable $th) {
            return response()->json([
                'error' => $th->getMessage(),
                'mensaje' => 'Error al crear el servicio pqrsf.'
            ], Response::HTTP_BAD_REQUEST);
        }
    }

    public function eliminar(Request $request)
    {
        try {
            $servicio = $this->serviciospqrsfRepository->eliminar($request);

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
     * Actualiza los servicios de un PQRSF
     * @param int $pqrsfId
     * @param ActualizarServiciosPqrsfRequest $request
     * @return JsonResponse
     * @author Thomas
     */
    public function actualizarServicios(int $pqrsfId,  ActualizarServiciosPqrsfRequest $request): JsonResponse
    {
        try {
            $respuesta = $this->serviciospqrsfRepository->actualizarServicios($pqrsfId, $request->validated());
            return response()->json($respuesta, Response::HTTP_OK);
        } catch (\Throwable $th) {
            return response()->json([
                'res' => false,
                'error' => $th->getMessage(),
            ], Response::HTTP_BAD_REQUEST);
        }
    }

    /**
     * Elimina un servicio de un PQRSF
     * @param int $pqrsfId
     * @param Request $request
     * @return JsonResponse
     * @author Thomas
     */
    public function removerServicio(int $pqrsfId, Request $request): JsonResponse
    {
        try {
            $respuesta = $this->serviciospqrsfRepository->removerServicio($pqrsfId, $request->all());
            return response()->json($respuesta, Response::HTTP_OK);
        } catch (\Throwable $th) {
            return response()->json([
                'res' => false,
                'error' => $th->getMessage(),
            ], Response::HTTP_BAD_REQUEST);
        }
    }
}
