<?php

namespace App\Http\Modules\ClienteMesaAyuda\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Modules\ClienteMesaAyuda\Repositories\ClienteMesaAyudaRepository;
use App\Http\Modules\ClienteMesaAyuda\Requests\CrearClienteMesaAyudaRequest;
use App\Http\Modules\ClienteMesaAyuda\Services\ClientesMesaAyudaService;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Http;

class ClientemesaayudaController extends Controller
{
    public function __construct(protected ClienteMesaAyudaRepository $clienteMesaAyudaRepository, protected ClientesMesaAyudaService $clientesMesaAyudaService) {}

    /**
     *  Se listan los Cliente que integran las mesas de ayuda
     *
     * @author Alejandro_Ocampo
     */
    public function listar(Request $request)
    {
        try {
            $clientesMesaAyuda = $this->clienteMesaAyudaRepository->listarClientes($request);
            return response()->json($clientesMesaAyuda, Response::HTTP_OK);
        } catch (\Throwable $th) {
            return response()->json([
                'mensaje' => 'Error al consultar los clientes de mesa de ayuda.',
                'error' => $th->getMessage()
            ], Response::HTTP_BAD_REQUEST);
        }
    }


    /**
     * Crear cliente para integrarlo a la mesa de ayuda
     *
     * @param  $request { nombre, endpoin_pendientes, endpoin_accion_gestionado, endpoin_accion_comentario_solicitante, endpoin_accion_reasignar, endpoin_accion_solucionar }
     * @author Alejandro_Ocampo
     */
    public function crearClienteMesaAyuda(CrearClienteMesaAyudaRequest $request)
    {
        try {
            $cliente = $this->clientesMesaAyudaService->crear($request->validated());
            return response()->json($cliente, Response::HTTP_CREATED);
        } catch (\Throwable $th) {
            return response()->json([
                'error' => $th->getMessage(),
                'mensaje' => 'ha ocurrido un error al crear el cliente de la mesa de ayuda'
            ], $th->getCode() ?: Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    public function editar(CrearClienteMesaAyudaRequest $request, int $id)
    {
        try {
            $editar = $this->clientesMesaAyudaService->editar($request->validated(), $id);
            return response()->json($editar, Response::HTTP_OK);
        } catch (\Throwable $th) {
            return response()->json(['error' => $th->getMessage()], 400);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
