<?php

namespace App\Http\Modules\Eventos\TipoEventos\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Http\JsonResponse;
use App\Http\Controllers\Controller;
use App\Http\Modules\Eventos\TipoEventos\Models\TipoEvento;
use App\Http\Modules\Eventos\TipoEventos\Repositories\TipoEventoRepository;
use App\Http\Modules\Eventos\TipoEventos\Requests\ActualizarTipoEventoRequest;
use App\Http\Modules\Eventos\TipoEventos\Requests\CrearTipoEventoRequest;

class TipoEventoController extends Controller
{
    private $tipoEventoRepository;

    public function __construct(){
        $this->tipoEventoRepository = new TipoEventoRepository;
    }

    /**
     * lista los tipos de eventos
     * @param Request $request
     * @return Response
     * @author leon
     */
    public function listar(Request $request): JsonResponse
    {
        $tipoEvento = $this->tipoEventoRepository->listarClasificacion($request->page);
        try {
            return response()->json([
                'res' => true,
                'data' => $tipoEvento
            ], Response::HTTP_OK);
        } catch (\Throwable $th) {
            return response()->json([
                'res' => false,
                'mensaje' => 'Error al listar los tipos de eventos',
            ], Response::HTTP_BAD_REQUEST);
        }
    }

    public function listarConClasiArea(Request $request, $suceso_id )
    {
        try {
            $clasificacion = $this->tipoEventoRepository->listarConClasiArea($request, $suceso_id);
            return response()->json([
                'res' => true,
                'data' => $clasificacion
            ], Response::HTTP_OK);
        } catch (\Throwable $th) {
            return response()->json([
                'res' => false,
                'mensaje' => 'Error al recuperar los tipos de eventos según su clasificación de área',
            ], Response::HTTP_BAD_REQUEST);
        }
    }

    /**
     * Guarda un un tipo de evento
     * @param Request $request
     * @return Response
     * @author leon
     */
    public function crear(CrearTipoEventoRequest $request):JsonResponse{
        try {
            $tipoEvento = $this->tipoEventoRepository->crear($request->validated());
            return response()->json($tipoEvento, Response::HTTP_CREATED);
        } catch (\Throwable $th) {
            return response()->json($th->getMessage(), Response::HTTP_BAD_REQUEST);
        }
    }

    /**
     * Actualiza un tipo de evento
     * @param Request $request
     * @return Response
     * @author leon
     */
    public function actualizar(ActualizarTipoEventoRequest $request, TipoEvento $id){
        try {
            $this->tipoEventoRepository->actualizar($id, $request->validated());
            return response()->json([]);
        } catch (\Throwable $th) {
            return response()->json($th->getMessage(),400);
        }
    }
}
