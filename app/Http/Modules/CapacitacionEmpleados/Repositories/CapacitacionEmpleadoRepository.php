<?php

namespace App\Http\Modules\CapacitacionEmpleados\Repositories;

use App\Http\Modules\Bases\RepositoryBase;
use App\Http\Modules\CapacitacionEmpleados\Models\CapacitacionEmpleado;

class CapacitacionEmpleadoRepository extends RepositoryBase {

    protected $capacitacionEmpleadoModel;

    public function __construct(){
       $capacitacionEmpleadoModel = new CapacitacionEmpleado();
       parent::__construct($capacitacionEmpleadoModel);
       $this->capacitacionEmpleadoModel = $capacitacionEmpleadoModel;
    }

}
