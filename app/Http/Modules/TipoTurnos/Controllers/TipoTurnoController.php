<?php

namespace App\Http\Modules\TipoTurnos\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Modules\TipoTurnos\Models\TipoTurno;
use App\Http\Modules\TipoTurnos\Repositories\TipoTurnoRepository;
use App\Http\Modules\TipoTurnos\Requests\ActualizarTipoTurnoRequest;
use App\Http\Modules\TipoTurnos\Requests\GuardarTipoTurnoRequest;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class TipoTurnoController extends Controller
{
    private $tipoTurnoRepository;

    public function __construct(){
        $this->tipoTurnoRepository = new TipoTurnoRepository();
    }

    /**
     * lista los tipos de turnos
     * @param Request $request
     * @return $tipoTurno
     * @author Arles Garcia
     */
    public function listar(Request $request){
        try {
            $tipoTurno = $this->tipoTurnoRepository->listar($request);
            return response()->json($tipoTurno, 200);
        } catch (\Throwable $th) {
            return response()->json($th->getMessage(), 400);
        }
    }

    /**
     * Guarda un tipo de turno
     * @param Request $request
     * @return Response
     * @author Arles Garcia
     */
    public function guardar(GuardarTipoTurnoRequest $request): JsonResponse
    {
        try {
            $tipoTurno = $this->tipoTurnoRepository->guardar($request->validated());
            return response()->json($tipoTurno, 201);
        } catch (\Throwable $th) {
            return response()->json($th->getMessage(), 400);
        }
    }

    /**
     * Actualiza un tipo de turno
     * @param Request $request
     * @param TipoTurno
     * @return Response
     * @author Arles Garcia
     */
    public function actualizar(ActualizarTipoTurnoRequest $request, TipoTurno $tipo_turno): JsonResponse
    {
        try {
            $tipoTurno = $this->tipoTurnoRepository->actualizar($tipo_turno, $request->validated());
            return response()->json($tipoTurno, 200);
        } catch (\Throwable $th) {
            return response()->json($th->getMessage(), 400);
        }
    }
}
