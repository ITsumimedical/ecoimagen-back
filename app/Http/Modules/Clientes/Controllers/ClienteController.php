<?php

namespace App\Http\Modules\Clientes\Controllers;

use Throwable;
use Illuminate\Http\Response;
use Illuminate\Http\JsonResponse;
use App\Http\Controllers\Controller;
use App\Http\Modules\Clientes\Repositories\ClienteRepository;
use App\Http\Modules\Clientes\Request\ClienteRequest;
use App\Http\Modules\Clientes\Services\ClienteService;

class ClienteController extends Controller
{

    public function __construct(
        protected ClienteRepository $clienteRepository,
        protected ClienteService $clienteService
    ) {}

    /**
     * Esta función lista los clientes
     * @params 
     * @return JsonResponse
     * @throws Throwable
     * @author Daniel
     */
    public function listarClientes(): JsonResponse
    {
        try {
            $respuesta = $this->clienteRepository->listarClientes();
            return response()->json($respuesta, Response::HTTP_OK);
        } catch (Throwable $th) {
            return response()->json(['error' => $th->getMessage()], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    /**
     * Cambia el estado del cliente
     * @return Json
     * @author Daniel
     */
    public function cambiarEstado(int $clienteId): JsonResponse
    {
        try {
            $response = $this->clienteRepository->cambiarEstado($clienteId);
            return response()->json($response, Response::HTTP_OK);
        } catch (Throwable $th) {
            return response()->json(['error' => $th->getMessage()], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }
    public function crearClientes(ClienteRequest $request): JsonResponse
    {
        try {
            $respuesta = $this->clienteService->crearClientes($request->validated());
            return response()->json($respuesta, Response::HTTP_CREATED);
        } catch (\Throwable $th) {
            return response()->json(['error' => $th->getMessage()], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    public function actualizarClientes(ClienteRequest $request, int $id): JsonResponse
    {
        try {
            $cliente = $this->clienteService->actualizarClientes($request->all(), $id);
            return response()->json($cliente, Response::HTTP_OK);
        } catch (\Exception $th) {
            return response()->json([
                'error' => $th->getMessage(),
                'mensaje' => 'Ha ocurrido un error al actualizar'
            ], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }
}
