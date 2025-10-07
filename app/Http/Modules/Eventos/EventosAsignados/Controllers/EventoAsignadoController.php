<?php

namespace App\Http\Modules\Eventos\EventosAsignados\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Http\JsonResponse;
use App\Http\Controllers\Controller;
use App\Http\Modules\Eventos\EventosAsignados\Repositories\EventoAsignadoRepository;

class EventoAsignadoController extends Controller
{
    public function __construct(
        private EventoAsignadoRepository $eventoAdversoAsignadoRepository){
    }

    /**
     * lista los usuarios asignados a los eventos adversos
     * @param Request $request
     * @return Response
     * @author leon
     */
    public function listar($id): JsonResponse
    {
        $eventoAdverso = $this->eventoAdversoAsignadoRepository->listarUsuarios($id);
        try {
            return response()->json($eventoAdverso, Response::HTTP_OK);
        } catch (\Throwable $th) {
            return response()->json([
                'res' => false,
                'mensaje' => 'Error al listar los usuarios asignados al evento adverso',
            ], Response::HTTP_BAD_REQUEST);
        }
    }
}
