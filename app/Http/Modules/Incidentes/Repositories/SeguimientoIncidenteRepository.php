<?php

namespace App\Http\Modules\Incidentes\Repositories;

use App\Http\Modules\Bases\RepositoryBase;
use App\Http\Modules\Incidentes\Models\SeguimientoIncidente;

class SeguimientoIncidenteRepository extends RepositoryBase {

    protected $seguimientoIncidenteModel;

    public function __construct() {
        $this->seguimientoIncidenteModel = new SeguimientoIncidente();
        parent::__construct($this->seguimientoIncidenteModel);
    }

    public function listarConEmpleado($id){
        $seguimientos = SeguimientoIncidente::select(
            'seguimiento_incidentes.id', 'seguimiento_incidentes.incidente_id', 'seguimiento_incidentes.usuario_registra_id', 'seguimiento_incidentes.seguimiento',
            'seguimiento_incidentes.created_at'
        )
        ->join('users', 'users.id', 'usuario_registra_id')
        ->join('empleados', 'empleados.id', 'usuario_registra_id')
        ->where('seguimiento_incidentes.incidente_id',$id)
        ->get();

        return $seguimientos;
    }
}
