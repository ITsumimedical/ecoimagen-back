<?php

namespace App\Http\Modules\TipoHistorias\Repositories;

use App\Http\Modules\Bases\RepositoryBase;
use App\Http\Modules\TipoHistorias\Models\TipoHistoria;

class TipoHistoriaRepository extends RepositoryBase {

    protected $model;

    public function __construct(){
        $this->model = new TipoHistoria();
        parent::__construct($this->model);
    }

    public function listarTipoHistoria() {
        return $this->model->orderBy('id', 'asc')->get();
    }
}
