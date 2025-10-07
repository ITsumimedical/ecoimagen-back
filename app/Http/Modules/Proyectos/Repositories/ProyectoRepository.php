<?php

namespace App\Http\Modules\Proyectos\Repositories;

use App\Http\Modules\Bases\RepositoryBase;
use App\Http\Modules\Proyectos\Models\Proyecto;

class ProyectoRepository extends RepositoryBase {

    protected $proyectoModel;

    public function __construct() {
        $this->proyectoModel = new Proyecto();
        parent::__construct($this->proyectoModel);
    }

}
