<?php

namespace App\Http\Modules\CambioAgendas\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Http\JsonResponse;
use App\Http\Controllers\Controller;
use App\Http\Modules\Agendas\Repositories\AgendaRepository;
use App\Http\Modules\Agendas\Services\AgendaService;
use App\Http\Modules\CambioAgendas\Requests\CrearCambioAgendaRequest;
use App\Http\Modules\CambioAgendas\Repositories\CambioAgendaRepository;

class CambioAgendaController extends Controller
{
    private $cambioAgendaRepository;
    protected $agendaService;

    public function __construct(){
        $this->cambioAgendaRepository = new CambioAgendaRepository;
        $this->agendaService = new AgendaService;
    }

    public function crear(CrearCambioAgendaRequest $request): JsonResponse
    {
        try {
            $cambioAgenda = $this->cambioAgendaRepository->crear($request->validated());
            $actualizacion = $this->agendaService->cambioAgenda($cambioAgenda);
            return response()->json($actualizacion, Response::HTTP_CREATED);
        } catch (\Throwable $th) {
            return response()->json([
                'res' => false,
                'mensaje' => 'Error al crear !',
                'error' => $th->getMessage()
            ], Response::HTTP_BAD_REQUEST);
        }
    }

    public function listar($id)
    {
        try {
            $cambios = $this->cambioAgendaRepository->listarCambios($id);
            return response()->json($cambios, Response::HTTP_OK);
        } catch (\Throwable $th) {
            return response()->json([
                'res' => false,
                'error' => $th->getMessage(),
                'mensaje' => 'Error al listar los cambios de la agenda',
            ], Response::HTTP_BAD_REQUEST);
        }
    }
}
