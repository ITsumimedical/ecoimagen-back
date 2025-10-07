<?php

namespace App\Http\Modules\Turnos\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Modules\GestionTurnos\Repositories\GestionTurnoRepository;
use App\Http\Modules\GestionTurnos\Services\GestionTurnoService;
use App\Http\Modules\Turnos\Requests\CambiarEstadoTurnoRequest;
use App\Http\Modules\Turnos\Models\Turno;
use App\Http\Modules\Turnos\Repositories\TurnoRepository;
use App\Http\Modules\Turnos\Requests\ActualizarTurnoRequest;
use App\Http\Modules\Turnos\Requests\GuardarTurnoRequest;
use App\Http\Modules\Turnos\Services\TurnoService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class TurnoController extends Controller
{
    private $turnoRepository;
    private $service;
    // gestion de turno
    private $gestionTurnoRepository;
    private $gestionTurnoService;


    public function __construct(){
        $this->turnoRepository = new TurnoRepository();
        $this->service = new TurnoService;
        $this->gestionTurnoRepository = new GestionTurnoRepository();
        $this->gestionTurnoService = new GestionTurnoService;
    }

    /**
     * lista los turnos
     * @param Request $request
     * @return $turno
     * @author Arles Garcia
     * @edit David Peláez
     */
    public function listar(Request $request){
        try {
            $turnos = $this->turnoRepository->listar($request);
            return response()->json($turnos, 200);
        } catch (\Throwable $th) {
            return response()->json($th->getMessage(), 400);
        }
    }

    /**
     * Guardar un turno
     * @param Request $request
     * @return Response
     * @author Arles Garcia
     */
    public function guardar(GuardarTurnoRequest $request)
    {
        try {
            /** Recuperamos el ultimo registro que coincida con el tipo de turno */
            $ultimo_turno = $this->turnoRepository->ultimoRegistro($request->tipo_turno_id, $request->area_clinica_id);
            $codigo = 1;
            if($ultimo_turno){
                $codigo = $this->service->generarCodigo($ultimo_turno);
            }
            $data = $this->service->prepararData($request->validated(), $codigo);
            $turno = $this->turnoRepository->guardar($data);

            return response()->json($turno, 201);

        } catch (\Throwable $th) {
            return response()->json($th->getMessage(), 400);
        }
    }

    /**
     * Actualiza un turno
     * @param Request $request
     * @param Turno
     * @return Response
     * @author Arles Garcia
     */
    public function actualizar(ActualizarTurnoRequest $request, Turno $turno)
    {
        try {
            $turno = $this->turnoRepository->actualizar($turno, $request->validated());
            return response()->json($turno, 200);
        } catch (\Throwable $th) {
            return response()->json($th->getMessage(), 400);
        }
    }

    /**
     * cambia el estado del turno
     * @param Request $request
     * @param Turno $turno
     * @return Response
     * @author David Peláez
     */
    public function cambiarEstado(CambiarEstadoTurnoRequest $request, Turno $turno){
        try{
            DB::beginTransaction();
            $turnos = $this->turnoRepository->actualizar($turno, $request->validated());
            $data = $this->gestionTurnoService->prepararData($request->all(), $turno);
            $GestionTurno = $this->gestionTurnoRepository->guardar($data);
            DB::commit();
            return response()->json([$turnos,$GestionTurno],200);
        }catch(\Throwable $th){
            DB::rollBack();
            return response()->json($th->getMessage(), 400);
        }
    }
}
