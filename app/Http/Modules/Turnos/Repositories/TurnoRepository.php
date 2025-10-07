<?php

namespace App\Http\Modules\Turnos\Repositories;

use App\Http\Modules\Base\RepositoryBase;
use App\Http\Modules\Turnos\Models\Turno;

class TurnoRepository extends RepositoryBase{

    protected $model;

    function __construct(){
        $this->model = new Turno();
        parent::__construct($this->model);
    }

    /**
     * Lista los turnos
     * @param $request
     * @return Collection
     * @author David Peláez
     */
    public function listar($request){
        return $this->model
            ->whereEstado($request->estado_id)
            ->whereArea($request->area_clinica_id)
            ->whereTipo($request->tipo_turno_id)
            ->orderBy('created_at', 'desc')
            //->orderBy('', 'desc')
            ->paginate(10);
    }

    /**
     * Consultamos el ultimo registro
     * @param $tipoTurnoId
     * @return Model
     * @author Arles Garcia
     */
    public function ultimoRegistro($tipo_turno_id, $area_clinica_id){
       return $this->model->where('tipo_turno_id', $tipo_turno_id)
       ->where('area_clinica_id', $area_clinica_id)
       ->orderBy('created_at', 'desc')
       ->first();
    }

}
