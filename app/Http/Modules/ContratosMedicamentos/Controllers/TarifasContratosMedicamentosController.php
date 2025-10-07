<?php

namespace App\Http\Modules\ContratosMedicamentos\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Modules\ContratosMedicamentos\Repositories\TarifasContratosMedicamentosRepository;
use App\Http\Modules\ContratosMedicamentos\Requests\CrearTarifaContratoMedicamentosRequest;
use App\Http\Modules\ContratosMedicamentos\Requests\EditarTarifaContratoMedicamentosRequest;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Throwable;

class TarifasContratosMedicamentosController extends Controller
{
    public function __construct(
        private readonly TarifasContratosMedicamentosRepository $tarifasContratosMedicamentosRepository
    ) {}

    /**
     * Agrega una nueva tarifa relacionada a un contrato
     * @param CrearTarifaContratoMedicamentosRequest $request
     * @return JsonResponse
     * @throws Throwable
     * @author Thomas
     */
    public function crearTarifa(CrearTarifaContratoMedicamentosRequest $request): JsonResponse
    {
        try {
            $tarifa = $this->tarifasContratosMedicamentosRepository->crearTarifa($request->validated());
            return response()->json($tarifa, Response::HTTP_CREATED);
        } catch (Throwable $th) {
            return response()->json([
                'error' => $th->getMessage(),
                'mensaje' => 'Error al crear tarifa'
            ], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    /**
     * Lista las tarifas de un contrato de medicamentos
     * @param Request $request
     * @return JsonResponse
     * @throws Throwable
     * @author Thomas
     */
    public function listarTarifasContrato(Request $request): JsonResponse
    {
        try {
            $tarifas = $this->tarifasContratosMedicamentosRepository->listarTarifasContrato($request->all());
            return response()->json($tarifas, Response::HTTP_OK);
        } catch (Throwable $th) {
            return response()->json([
                'error' => $th->getMessage(),
                'mensaje' => 'Error al listar tarifas'
            ], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    /**
     * Lista los detalles de una tarifa
     * @param int $tarifaId
     * @return JsonResponse
     * @throws Throwable
     * @author Thomas
     */
    public function listarDetallesTarifa(int $tarifaId): JsonResponse
    {
        try {
            $tarifa = $this->tarifasContratosMedicamentosRepository->listarDetallesTarifa($tarifaId);
            return response()->json($tarifa, Response::HTTP_OK);
        } catch (Throwable $th) {
            return response()->json([
                'error' => $th->getMessage(),
                'mensaje' => 'Error al listar detalles de tarifa'
            ], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    /**
     * Edita una tarifa
     * @param int $tarifaId
     * @param EditarTarifaContratoMedicamentosRequest $request
     * @return JsonResponse
     * @throws Throwable
     * @author Thomas
     */
    public function editarTarifa(int $tarifaId, EditarTarifaContratoMedicamentosRequest $request): JsonResponse
    {
        try {
            $tarifa = $this->tarifasContratosMedicamentosRepository->editarTarifa($tarifaId, $request->validated());
            return response()->json($tarifa, Response::HTTP_OK);
        } catch (Throwable $th) {
            return response()->json([
                'error' => $th->getMessage(),
                'mensaje' => 'Error al editar tarifa'
            ], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    public function cambiarEstadoTarifa(int $tarifaId): JsonResponse
    {
        try {
            $response = $this->tarifasContratosMedicamentosRepository->cambiarEstadoTarifa($tarifaId, null);
            return response()->json($response, Response::HTTP_OK);
        } catch (\Throwable $th) {
            return response()->json([
                'error' => $th->getMessage(),
                'mensaje' => 'Error al cambiar estado de tarifa'
            ], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }
}
