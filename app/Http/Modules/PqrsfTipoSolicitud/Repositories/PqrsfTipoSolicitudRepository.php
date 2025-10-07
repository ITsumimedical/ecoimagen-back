<?php

namespace App\Http\Modules\PqrsfTipoSolicitud\Repositories;

use App\Http\Modules\Bases\RepositoryBase;
use App\Http\Modules\PqrsfTipoSolicitud\Models\PqrsfTipoSolicitud;

class PqrsfTipoSolicitudRepository extends RepositoryBase {
    protected $model;

    public function __construct() {
        $this->model = new PqrsfTipoSolicitud();
        parent::__construct($this->model);
    }
}