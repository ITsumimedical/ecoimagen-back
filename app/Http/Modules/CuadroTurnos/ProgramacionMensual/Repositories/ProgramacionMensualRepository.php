<?php

namespace App\Http\Modules\CuadroTurnos\ProgramacionMensual\Repositories;

use App\Http\Modules\Bases\RepositoryBase;
use App\Http\Modules\CuadroTurnos\ProgramacionMensual\Models\ProgramacionMensualTh;

class ProgramacionMensualRepository extends RepositoryBase {

    protected $programacionMensualModel;

    public function __construct() {
        $this->programacionMensualModel = new ProgramacionMensualTh();
        parent::__construct($this->programacionMensualModel);
    }

    public function listarPorEmpleado(){
        $programacionesEmpleados = ProgramacionMensualTh::select(
            'programacion_mensual_ths.*', 'empleados.nombre_completo', 'empleados.documento', 'sedes.nombre as sede', 'area_ths.nombre as area')
            ->join('empleados', 'empleados.id', 'programacion_mensual_ths.empleado_id')
            ->leftjoin('sedes', 'sedes.id', 'empleados.sede_id')
            ->leftjoin('area_ths', 'area_ths.id', 'empleados.areath_id')
            ->get();
        return $programacionesEmpleados;
    }

}
