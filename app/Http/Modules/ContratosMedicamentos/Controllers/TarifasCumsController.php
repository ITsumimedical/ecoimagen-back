<?php

namespace App\Http\Modules\ContratosMedicamentos\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Modules\ContratosMedicamentos\Repositories\TarifasCumsRepository;
use App\Http\Modules\ContratosMedicamentos\Requests\CargueMasivoCumsTarifaRequest;
use App\Http\Modules\ContratosMedicamentos\Requests\CrearCumTarifaRequest;
use App\Http\Modules\ContratosMedicamentos\Services\TarifasCumsService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Throwable;

class TarifasCumsController extends Controller
{
    public function __construct(
        private readonly TarifasCumsRepository $tarifasCumsRepository,
        private readonly TarifasCumsService    $tarifasCumsService
    )
    {
    }

    /**
     * Crear un cum de tarifa
     * @param CrearCumTarifaRequest $request
     * @return JsonResponse
     * @throws Throwable
     * @author Thomas
     */
    public function crearCumTarifa(CrearCumTarifaRequest $request): JsonResponse
    {
        try {
            $respuesta = $this->tarifasCumsService->crearCumTarifa($request->validated());
            return response()->json($respuesta, Response::HTTP_CREATED);
        } catch (Throwable $th) {
            return response()->json([
                'error' => $th->getMessage(),
                'mensaje' => 'Error al crear cum de tarifa'
            ], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    /**
     * Lista los cums de una tarifa
     * @param Request $request
     * @return JsonResponse
     * @throws Throwable
     * @author Thomas
     */
    public function listarCumsTarifa(Request $request): JsonResponse
    {
        try {
            $cumsTarifa = $this->tarifasCumsRepository->listarCumsTarifa($request->all());
            return response()->json($cumsTarifa, Response::HTTP_OK);
        } catch (Throwable $th) {
            return response()->json([
                'error' => $th->getMessage(),
                'mensaje' => 'Error al listar cums de tarifa'
            ], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    /**
     * Eliminar un cum de tarifa
     * @param int $cumTarifaId
     * @return JsonResponse
     * @throws Throwable
     * @author Thomas
     */
    public function eliminarCumTarifa(int $cumTarifaId): JsonResponse
    {
        try {
            $respuesta = $this->tarifasCumsRepository->eliminarCumTarifa($cumTarifaId);
            return response()->json($respuesta, Response::HTTP_OK);
        } catch (Throwable $th) {
            return response()->json([
                'error' => $th->getMessage(),
                'mensaje' => 'Error al eliminar cum de tarifa'
            ], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    /**
     * Cambiar precio de un cum de tarifa
     * @param int $cumTarifaId
     * @param Request $request
     * @return JsonResponse
     * @throws Throwable
     * @author Thomas
     */
    public function cambiarPrecioCumTarifa(int $cumTarifaId, Request $request): JsonResponse
    {
        try {
            $respuesta = $this->tarifasCumsRepository->cambiarPrecioCumTarifa($cumTarifaId, $request->all());
            return response()->json($respuesta, Response::HTTP_OK);
        } catch (Throwable $th) {
            return response()->json([
                'error' => $th->getMessage(),
                'mensaje' => 'Error al cambiar precio del cum de la tarifa'
            ], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }


    /**
     * Cargue masivo de cums de tarifa
     * @param CargueMasivoCumsTarifaRequest $request
     * @return JsonResponse
     * @throws Throwable
     * @author Thomas
     */
    public function cargueMasivoCumsTarifa(CargueMasivoCumsTarifaRequest $request): JsonResponse
    {
        try {
            $respuesta = $this->tarifasCumsService->cargueMasivoCumsTarifa($request->validated());
            return response()->json($respuesta, Response::HTTP_CREATED);
        } catch (Throwable $th) {
            return response()->json([
                'error' => $th->getMessage(),
                'mensaje' => 'Error al crear cum de tarifa'
            ], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }
}
