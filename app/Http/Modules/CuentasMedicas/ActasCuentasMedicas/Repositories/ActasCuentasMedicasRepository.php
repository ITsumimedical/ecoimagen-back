<?php

namespace App\Http\Modules\CuentasMedicas\ActasCuentasMedicas\Repositories;

use App\Http\Modules\Bases\RepositoryBase;
use App\Http\Modules\CuentasMedicas\ActasCuentasMedicas\Models\ActasCuentasMedica;

class ActasCuentasMedicasRepository extends RepositoryBase {

    protected $actasCuentaMedica;

    public function __construct() {
        $this->actasCuentaMedica = new ActasCuentasMedica();
        parent::__construct($this->actasCuentaMedica);
    }

    public function actas($data){
        return $this->actasCuentaMedica->select('id','nombre','ruta','created_at')
        ->where('prestador_id',$data['prestador'])
        ->where('created_at','>=',$data['fechaDesde'])
        ->where('created_at','<=',$data['fechaHasta'].' 23:59:59')
        ->get();

    }



}
