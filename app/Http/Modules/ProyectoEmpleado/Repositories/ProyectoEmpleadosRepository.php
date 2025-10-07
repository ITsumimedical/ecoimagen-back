<?php

namespace App\Http\Modules\ProyectoEmpleado\Repositories;

use App\Http\Modules\Bases\RepositoryBase;
use App\Http\Modules\ProyectoEmpleado\Models\ProyectoEmpleado;

class ProyectoEmpleadosRepository extends RepositoryBase {

    protected $proyectoEmpleadoModel;

    public function __construct(){
        $this->proyectoEmpleadoModel = new ProyectoEmpleado();
        parent::__construct($this->proyectoEmpleadoModel);
    }
}
