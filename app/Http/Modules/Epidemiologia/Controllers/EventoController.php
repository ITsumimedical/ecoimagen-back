<?php

namespace App\Http\Modules\Epidemiologia\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Modules\Epidemiologia\Repositories\EventoRepository;
use App\Http\Modules\Epidemiologia\Requests\CrearEventoRequest;
use App\Http\Modules\Epidemiologia\Services\EventoService;
use Illuminate\Http\Response;
use Illuminate\Http\Request;

class EventoController extends Controller
{
    public function __construct(private EventoRepository $eventoRepository, private EventoService $eventoService) {}

    /**
     * Funcion para listar los eventos sivigila
     * @author Sofia O
     */
    public function listarEventos(Request $request)
    {
        try {
            $listarEvento = $this->eventoService->listarEventos($request->all());
            return response()->json($listarEvento, Response::HTTP_OK);
        } catch (\Throwable $th) {
            return response()->json([
                'error' => 'Error al listar los eventos'
            ], Response::HTTP_BAD_REQUEST);
        }
    }

    /**
     * Funcion para crear el evento epidemiologico
     * @author Sofia O
     */
    public function crearEventos(CrearEventoRequest $request)
    {
        try {
            $crearEvento = $this->eventoRepository->crearEvento($request->validated());
            return response()->json($crearEvento, Response::HTTP_CREATED);
        } catch (\Throwable $th) {
            return response()->json([
                'messaje' => 'Error al crear el evento'
            ], Response::HTTP_BAD_REQUEST);
        }
    }

    /**
     * Funcion para actulizar evento epidemiologico
     * @author Sofia O
     */
    public function actualizarEventos(CrearEventoRequest $request, $id)
    {
        try {
            $actualizarEvento = $this->eventoService->actualizarEvento($request->validated(), $id);
            return response()->json($actualizarEvento, Response::HTTP_OK);
        } catch (\Throwable $th) {
            return response()->json([
                'messaje' => 'Error al actualizar el evento'
            ], Response::HTTP_BAD_REQUEST);
        }
    }

    /**
     * Funcion para cambiar el estado del evento
     * @author Sofia O
     */
    public function cambiarEstadoEvento($id)
    {
        try {
            $cambiarEstado = $this->eventoService->actualizarEstado($id);
            return response()->json($cambiarEstado, Response::HTTP_OK);
        } catch (\Throwable $th) {
            return response()->json([
                'messaje' => 'Error al cambiar el estado del evento'
            ], Response::HTTP_BAD_REQUEST);
        }
    }
}
