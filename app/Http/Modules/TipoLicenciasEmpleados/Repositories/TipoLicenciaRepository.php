<?php

namespace App\Http\Modules\TipoLicenciasEmpleados\Repositories;

use App\Http\Modules\Bases\RepositoryBase;
use App\Http\Modules\TipoLicenciasEmpleados\Models\TipoLicenciaEmpleado;

class TipoLicenciaRepository extends RepositoryBase {

    protected $tipoLicenciaModel;

    public function __construct(){
       $tipoLicenciaModel = new TipoLicenciaEmpleado();
       parent::__construct($tipoLicenciaModel);
       $this->tipoLicenciaModel = $tipoLicenciaModel;
    }

}
