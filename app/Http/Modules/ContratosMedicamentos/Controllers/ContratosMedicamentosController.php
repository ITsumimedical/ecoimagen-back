<?php

namespace App\Http\Modules\ContratosMedicamentos\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Modules\ContratosMedicamentos\Repositories\ContratosMedicamentosRepository;
use App\Http\Modules\ContratosMedicamentos\Requests\CrearContratoMedicamentoRequest;
use App\Http\Modules\ContratosMedicamentos\Requests\EditarContratoMedicamentoRequest;
use App\Http\Modules\ContratosMedicamentos\Services\ContratosMedicamentosService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Throwable;

class ContratosMedicamentosController extends Controller
{
    public function __construct(
        private readonly ContratosMedicamentosRepository $contratosMedicamentosRepository,
        private readonly ContratosMedicamentosService    $contratosMedicamentosService
    ) {}

    /**
     * Crear un nuevo contrato
     * @param CrearContratoMedicamentoRequest $request
     * @return JsonResponse
     * @throws Throwable
     * @author Thomas
     */
    public function crearContrato(CrearContratoMedicamentoRequest $request): JsonResponse
    {
        try {
            $response = $this->contratosMedicamentosService->crearContrato($request->validated());
            return response()->json($response, Response::HTTP_CREATED);
        } catch (Throwable $th) {
            return response()->json([
                'error' => $th->getMessage(),
                'mensaje' => 'Error al crear contrato'
            ], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    /**
     * Listar contratos de un prestador
     * @param Request $request
     * @return JsonResponse
     * @throws Throwable
     * @author Thomas
     */
    public function listarContratosPrestador(Request $request): JsonResponse
    {
        try {
            $response = $this->contratosMedicamentosRepository->listarContratosPrestador($request->all());
            return response()->json($response, Response::HTTP_OK);
        } catch (Throwable $th) {
            return response()->json([
                'error' => $th->getMessage(),
                'mensaje' => 'Error al listar contratos'
            ], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    /**
     * Guarda los adjuntos de la novedad del contrato
     * @param Request $request
     * @return JsonResponse
     * @throws Throwable
     * @author Thomas
     */
    public function guardarInformacionAdjuntos(Request $request): JsonResponse
    {
        try {
            $response = $this->contratosMedicamentosService->guardarInformacionAdjuntos($request->all());
            return response()->json($response, Response::HTTP_CREATED);
        } catch (Throwable $th) {
            return response()->json([
                'mensaje' => 'Error al guardar los adjuntos del contrato!',
                'error' => $th->getMessage()
            ], Response::HTTP_BAD_REQUEST);
        }
    }

    /**
     * Listar detalles de un contrato
     * @param int $contratoId
     * @return JsonResponse
     * @throws Throwable
     * @author Thomas
     */
    public function listarDetallesContrato(int $contratoId): JsonResponse
    {
        try {
            $contrato = $this->contratosMedicamentosRepository->listarDetallesContrato($contratoId);
            return response()->json($contrato, Response::HTTP_OK);
        } catch (Throwable $th) {
            return response()->json([
                'error' => $th->getMessage(),
                'mensaje' => 'Error al listar detalles del contrato'
            ], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    /**
     * Editar un contrato
     * @param int $contratoId
     * @param EditarContratoMedicamentoRequest $request
     * @return JsonResponse
     * @throws Throwable
     * @author Thomas
     */
    public function editarContrato(int $contratoId, EditarContratoMedicamentoRequest $request): JsonResponse
    {
        try {
            $response = $this->contratosMedicamentosService->editarContrato($contratoId, $request->validated());
            return response()->json($response, Response::HTTP_OK);
        } catch (Throwable $th) {
            return response()->json([
                'error' => $th->getMessage(),
                'mensaje' => 'Error al editar contrato'
            ], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    public function cambiarEstadoContrato(int $contratoId): JsonResponse
    {
        try {
            $response = $this->contratosMedicamentosService->cambiarEstadoContrato($contratoId);
            return response()->json($response, Response::HTTP_OK);
        } catch (\Throwable $th) {
            return response()->json([
                'error' => $th->getMessage(),
                'mensaje' => 'Error al cambiar estado del contrato'
            ], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }
}
