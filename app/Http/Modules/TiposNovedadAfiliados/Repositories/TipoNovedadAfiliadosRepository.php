<?php

namespace App\Http\Modules\TiposNovedadAfiliados\Repositories;


use App\Http\Modules\Bases\RepositoryBase;
use App\Http\Modules\TiposNovedadAfiliados\Models\tipoNovedadAfiliados;

class TipoNovedadAfiliadosRepository extends RepositoryBase {
    protected $model;

    public function __construct() {
        $this->model = new tipoNovedadAfiliados();
        parent::__construct($this->model);
    }
}