<?php

namespace App\Http\Modules\Incidentes\Repositories;

use App\Http\Modules\Bases\RepositoryBase;
use App\Http\Modules\Incidentes\Models\Incidente;

class IncidenteRepository extends RepositoryBase {

    protected $incidenteModel;

    public function __construct() {
        $this->incidenteModel = new Incidente();
        parent::__construct($this->incidenteModel);
    }

    public function listarSeguimiento(){
        $seguimientos = Incidente::Select('incidentes.id', 'incidentes.usuario_reporta_id', 'incidentes.empleado_id', 'incidentes.estado_id', 'incidentes.fecha_incidente',
        'incidentes.periodicidad_seguimiento', 'incidentes.gravedad', 'incidentes.descripcion', 'incidentes.comentarios', 'incidentes.resultado', 'incidentes.created_at',
        'empleados.documento', 'users.email as emailReportante',
        )
        ->selectRaw("CONCAT(empleados.primer_nombre,' ',empleados.primer_apellido,' ',empleados.segundo_nombre,' ',empleados.segundo_apellido) as nombre_completo")
        ->join('empleados', 'empleados.id', 'incidentes.empleado_id')
        ->join('users', 'users.id', 'incidentes.usuario_reporta_id')
        ->join('empleados as empleadoReporta', 'users.id', 'empleadoReporta.user_id')
        ->where('empleados.jefe_inmediato_id', auth()->user()->id)
        ->get();

        return $seguimientos;
    }
}
