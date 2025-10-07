<?php

namespace App\Http\Modules\ProyectosEmpleados\Repositories;

use App\Http\Modules\Bases\RepositoryBase;
use App\Http\Modules\ProyectosEmpleados\Models\ProyectosEmpleado;

class ProyectoEmpleadoRepository extends RepositoryBase {

    protected $proyectoEmpleadoModel;

    public function __construct(){
        $this->proyectoEmpleadoModel = new ProyectosEmpleado();
        parent::__construct($this->proyectoEmpleadoModel);
    }
}
