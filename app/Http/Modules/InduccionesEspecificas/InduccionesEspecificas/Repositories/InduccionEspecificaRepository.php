<?php

namespace App\Http\Modules\InduccionesEspecificas\InduccionesEspecificas\Repositories;

use App\Http\Modules\Bases\RepositoryBase;
use App\Http\Modules\InduccionesEspecificas\InduccionesEspecificas\Models\InduccionEspecifica;

class InduccionEspecificaRepository extends RepositoryBase {

    protected $induccionModel;

    public function __construct() {
        $this->induccionModel = new InduccionEspecifica();
        parent::__construct($this->induccionModel);
    }

    public function listarConEmpleado(){
        $induccion = InduccionEspecifica::select(
            'induccion_especificas.id', 'induccion_especificas.empleado_id', 'induccion_especificas.usuario_registra_id', 'induccion_especificas.fecha_inicio_induccion',
            'induccion_especificas.fecha_finalizacion_induccion', 'induccion_especificas.cumplio_totalidad', 'induccion_especificas.firma_facilitador', 'induccion_especificas.firma_empleado',
            'induccion_especificas.activo', 'empleados.primer_nombre as empleadoInducido', 'empleados.primer_nombre',  'empleados.documento', 'empleados.email_corporativo', 'empleados.celular',
            'empleadoReporta.primer_nombre as empleadoReporta',
        )
        ->join('empleados', 'empleados.id', 'empleado_id')
        ->join('users', 'users.id', 'usuario_registra_id')
        ->join('empleados as empleadoReporta', 'users.id', 'empleadoReporta.user_id')
        ->get();

        return $induccion;

    }
}
