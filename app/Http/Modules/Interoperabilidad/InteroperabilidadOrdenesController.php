<?php

namespace App\Http\Modules\Interoperabilidad;

use App\Http\Controllers\Controller;
use App\Http\Modules\Interoperabilidad\Request\ActualizarOrdenDetalleEstadoRequest;
use App\Http\Modules\Interoperabilidad\Request\ActualizarOrdenDetalleRepRequest;
use App\Http\Modules\Interoperabilidad\Request\CrearOrdenMedicamentoRequest;
use App\Http\Modules\Interoperabilidad\Request\CrearOrdenProcedimientoRequest;
use App\Http\Modules\Ordenamiento\Models\Orden;
use App\Http\Modules\Ordenamiento\Models\OrdenProcedimiento;
use App\Http\Modules\Ordenamiento\Services\OrdenInteroperabilidadService;
use App\Jobs\EnvioOrdenFomag;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Symfony\Component\HttpKernel\Exception\HttpExceptionInterface;

class InteroperabilidadOrdenesController extends Controller
{
    public function __construct(
        protected InteroperabilidadOrdenesService $interoperabilidadOrdenesService,
        protected OrdenInteroperabilidadService $ordenInteroperabilidadService
    ) {
    }

    /**
     * actualiza el estado de la orden
     * @param Request $request
     * @param OrdenProcedimiento $detalle
     * @author David Peláez
     */
    public function actualizarEstado(ActualizarOrdenDetalleEstadoRequest $request, OrdenProcedimiento $detalle)
    {
        try {
            $response = $this->interoperabilidadOrdenesService->actualizarOrdenDetalle($request->validated(), $detalle);
            return response()->json($response, 200);
        } catch (\Throwable $th) {
            return response()->json([], $th->getCode());
        }
    }

    /**
     * actualiza el estado de la orden
     * @param Request $request
     * @param OrdenProcedimiento $detalle
     * @author David Peláez
     */
    public function actualizarRep(ActualizarOrdenDetalleRepRequest $request, OrdenProcedimiento $detalle)
    {
        try {
            $response = $this->interoperabilidadOrdenesService->actualizarOrdenDetalle($request->validated(), $detalle);
            return response()->json($response, 200);
        } catch (\Throwable $th) {
            return response()->json([], $th->getCode());
        }
    }

    /**
     * actualiza la columna enviado de una orden
     * @param Request $request
     * @param Orden
     * @author David Peláez
     */
    public function respuestaTranscripcion(Request $request, Orden $orden)
    {
        try {
            $response = $this->interoperabilidadOrdenesService->respuestaTranscripcion($orden);
            return response()->json($response, 200);
        } catch (\Throwable $th) {
            return response()->json([
                "error" => $th->getMessage()
            ], $th->getCode());
        }
    }

    public function enviar(Request $request)
    {
        set_time_limit(-1);
        try {
            // sleep(1);
            // EnvioOrdenFomag::dispatch($orden, $this->ordenInteroperabilidadService, 3352)
            //     ->onQueue('interoperabilidad');

            return response()->json('enviado');
        } catch (\Throwable $th) {
            return response()->json($th->getMessage());
        }
    }

    /**
     * Crea una Orden de Procedimientos proveniente de FOMAG
     * @param CrearOrdenProcedimientoRequest $request
     * @return JsonResponse
     * @throws \Throwable
     * @author Thomas
     */
    public function crearOrdenProcedimiento(CrearOrdenProcedimientoRequest $request): JsonResponse
    {
        try {
            $response = $this->ordenInteroperabilidadService->crearOrdenProcedimiento($request->validated());

            return response()->json([
                'data' => $response,
                'status' => 'success',
                'message' => 'Orden creada correctamente.'
            ], Response::HTTP_CREATED);

        } catch (\Throwable $th) {
            $status = $th instanceof HttpExceptionInterface
                ? $th->getStatusCode()
                : Response::HTTP_INTERNAL_SERVER_ERROR;

            return response()->json([
                'error' => $th->getMessage(),
                'status' => 'error'
            ], $status);
        }
    }

    /**
     * Crea una Orden de Medicamentos proveniente de FOMAG
     * @param CrearOrdenMedicamentoRequest $request
     * @return JsonResponse
     * @throws \Throwable
     * @author Thomas
     */
    public function crearOrdenMedicamento(CrearOrdenMedicamentoRequest $request): JsonResponse
    {
        try {
            $response = $this->ordenInteroperabilidadService->crearOrdenMedicamento($request->validated());

            return response()->json([
                'data' => $response,
                'status' => 'success',
                'message' => 'Orden creada correctamente.'
            ], Response::HTTP_CREATED);
        } catch (\Throwable $th) {
            $status = $th instanceof HttpExceptionInterface
                ? $th->getStatusCode()
                : Response::HTTP_INTERNAL_SERVER_ERROR;

            return response()->json([
                'error' => $th->getMessage(),
                'status' => 'error'
            ], $status);
        }
    }
}
