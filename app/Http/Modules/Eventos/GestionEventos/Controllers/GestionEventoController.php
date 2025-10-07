<?php

namespace App\Http\Modules\Eventos\GestionEventos\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Http\JsonResponse;
use App\Http\Controllers\Controller;
use App\Http\Modules\Eventos\GestionEventos\Requests\CrearGestionEventoRequest;
use App\Http\Modules\Eventos\GestionEventos\Repositories\GestionEventoRepository;

class GestionEventoController extends Controller
{
    private $gestionEventoAdversoRepository;

    public function __construct(){
        $this->gestionEventoAdversoRepository = new GestionEventoRepository();
    }

    /**
     * Guarda un análisis de un evento adverso
     * @param Request $request
     * @return Response
     * @author leon
     */
    public function crear(CrearGestionEventoRequest $request):JsonResponse{
        try {
            $gestionEvento = $this->gestionEventoAdversoRepository->crear($request->validated());
            return response()->json($gestionEvento, Response::HTTP_CREATED);
        } catch (\Throwable $th) {
            return response()->json($th->getMessage(), Response::HTTP_BAD_REQUEST);
        }
    }

    public function historicoGestionEvento($evento_adverso_id)
    {
        try {
            $historico = $this->gestionEventoAdversoRepository->historicoGestionEvento($evento_adverso_id);
            return response()->json($historico);
        } catch (\Throwable $th) {
            return response()->json(['error' => $th->getMessage()], 400);
        }
    }
}
