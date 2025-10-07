<?php

namespace App\Http\Modules\GestionTurnos\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Modules\GestionTurnos\Models\GestionTurno;
use App\Http\Modules\GestionTurnos\Repositories\GestionTurnoRepository;
use App\Http\Modules\GestionTurnos\Requests\ActualizarGestionTurnoRequest;
use App\Http\Modules\GestionTurnos\Requests\GuardarGestionTurnoRequest;
use App\Http\Modules\GestionTurnos\Services\GestionTurnoService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class GestionTurnoController extends Controller
{
    private $gestionTurnoRepository;
    private $gestionTurnoService;

    public function __construct(){
        $this->gestionTurnoRepository = new GestionTurnoRepository();
        $this->gestionTurnoService = new GestionTurnoService();
    }

    /**
     * lista gestion turnos
     * @param Request $request
     * @return $gestionTurno
     * @author Arles Garcia
     */
    public function listar(Request $request){
        try {
            $gestionTurno = $this->gestionTurnoRepository->listar($request);
            return response()->json($gestionTurno, 200);
        } catch (\Throwable $th) {
            return response()->json($th->getMessage(), 400);
        }
    }

    /**
     * Guardar una gestion turno
     * @param Request $request
     * @return Response
     * @author Arles Garcia
     */
    public function guardar(GuardarGestionTurnoRequest $request): JsonResponse
    {
        try {
            $gestionTurno = $this->gestionTurnoRepository->guardar($request->validated());
            return response()->json($gestionTurno, 201);
        } catch (\Throwable $th) {
            return response()->json($th->getMessage(), 400);
        }
    }

    /**
     * Actualiza un gestion turno
     * @param Request $request
     * @param GestionTurno
     * @return Response
     * @author Arles Garcia
     */
    public function actualizar(ActualizarGestionTurnoRequest $request, GestionTurno $gestion): JsonResponse
    {
        try {
            $gestionTurno = $this->gestionTurnoRepository->actualizar($gestion, $request->validated());
            return response()->json($gestionTurno, 200);
        } catch (\Throwable $th) {
            return response()->json($th->getMessage(), 400);
        }
    }
}
