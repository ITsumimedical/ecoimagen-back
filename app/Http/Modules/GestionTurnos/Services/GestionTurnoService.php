<?php

namespace App\Http\Modules\GestionTurnos\Services;

use App\Http\Modules\GestionTurnos\Repositories\GestionTurnoRepository;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

class GestionTurnoService
{
    private $gestionTurnoRepository;

    function __construct(){
        $this->gestionTurnoRepository = new GestionTurnoRepository();
    }

    public function prepararData($data,$turno){
        $data['user_id'] = Auth::id();
        $data['turno_id'] = $turno->id;
        if($data['estado_id'] == 27){
            $data['descripcion'] = 'Paciente esperando en sala';
        }
        if($data['estado_id'] == 28){
            $data['descripcion'] = 'Llamando al paciente';
        }
        if($data['estado_id'] == 29){
            $data['descripcion'] = 'Atendiendo al paciente';
        }
        if($data['estado_id'] == 30){
            $data['descripcion'] = 'Finalizo atencion al paciente';
        }
        if($data['estado_id'] == 31){
            $data['descripcion'] = 'Paciente esperando en sala triage';
        }
        if($data['estado_id'] == 31){
            $data['descripcion'] = 'Paciente en triage';
        }
        if($data['estado_id'] == 32){
            $data['descripcion'] = 'Paciente esperando en sala triage';
        }
        if($data['estado_id'] == 33){
            $data['descripcion'] = 'Paciente no atendio llamado';
        }
        return $data;
    }


}
