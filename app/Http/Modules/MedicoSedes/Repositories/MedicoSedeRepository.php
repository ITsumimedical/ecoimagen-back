<?php

namespace App\Http\Modules\MedicoSedes\Repositories;

use App\Http\Modules\Bases\RepositoryBase;
use App\Http\Modules\Empleados\Models\Empleado;
use App\Http\Modules\MedicoSedes\Models\medicoSede;

class MedicoSedeRepository extends RepositoryBase{

    public function __construct(protected medicoSede $medicoSedeModel){
        parent::__construct($medicoSedeModel);
    }

    public function listarConSede($id){
        $medico = Empleado::select('empleados.id',
                                   'sedes.rep_id',
                                   'empleados.primer_nombre',
                                   'empleados.segundo_nombre',
                                   'empleados.primer_apellido',
                                   'empleados.segundo_apellido')

        ->selectRaw("CONCAT(empleados.primer_nombre,' ',empleados.segundo_nombre,' ',empleados.primer_apellido,' ',empleados.segundo_apellido) as nombre_completo")
        ->join('sedes', 'sedes.id', 'empleados.sede_id')
        ->join('contrato_empleados', 'contrato_empleados.empleado_id', 'empleados.id')
        ->where('sedes.rep_id', $id)
        ->where('empleados.medico', 1)
        ->where('contrato_empleados.activo', 1)
        ->get();
        return $medico;
    }
}
