<?php

namespace App\Http\Modules\TipoAfiliaciones\Repositories;

use App\Http\Modules\Bases\RepositoryBase;
use App\Http\Modules\TipoAfiliaciones\Models\TipoAfiliacion;

class TipoAfiliacionRepository extends RepositoryBase {

    protected $tipoAfiliacionModel;

    public function __construct() {
        $this->tipoAfiliacionModel = new TipoAfiliacion();
        parent::__construct($this->tipoAfiliacionModel);
    }
}
