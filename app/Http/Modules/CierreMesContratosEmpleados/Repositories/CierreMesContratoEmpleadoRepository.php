<?php

namespace App\Http\Modules\CierreMesContratosEmpleados\Repositories;

use App\Http\Modules\Bases\RepositoryBase;
use App\Http\Modules\CierreMesContratosEmpleados\Models\CierreMesContratoEmpleado;

class CierreMesContratoEmpleadoRepository extends RepositoryBase {

    protected $cierreMesModel;

    public function __construct() {
        $this->cierreMesModel = new CierreMesContratoEmpleado();
        parent::__construct($this->cierreMesModel);
    }

    public function crearCierreMes($key, $request){
        $this->cierreMesModel->create([
            'empleado_id' => $key->empleado_id,
            'contrato_id' => $key->contrato_id,
            'activo' => $key->activo,
            'fecha_cierre_mes' => $request
        ]);

    }

    public function listarCierres(){
        $cierre = CierreMesContratoEmpleado::select('cierre_mes_contrato_empleados.fecha_cierre_mes')
        ->distinct()->get();

        return $cierre;
    }
}
