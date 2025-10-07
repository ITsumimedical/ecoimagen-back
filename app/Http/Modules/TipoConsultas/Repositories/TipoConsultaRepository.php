<?php

namespace App\Http\Modules\TipoConsultas\Repositories;

use App\Http\Modules\Bases\RepositoryBase;
use App\Http\Modules\TipoConsultas\Models\TipoConsulta;

class TipoConsultaRepository extends RepositoryBase
{
    protected $model;

    public function __construct(){
        $this->model = new TipoConsulta();
        parent::__construct($this->model);
    }

    public function obtenerTipoConsultaNobre($nombre){
        return  $this->model->select(['id'])
        ->where('nombre',$nombre)->first();
    }
}
