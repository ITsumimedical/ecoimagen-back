<?php

namespace App\Http\Modules\TipoAfiliados\Repositories;

use App\Http\Modules\Bases\RepositoryBase;
use App\Http\Modules\TipoAfiliados\Models\TipoAfiliado;

class TipoAfiliadoRepository extends RepositoryBase {

    protected $tipoAfiliadoModel;

    public function __construct() {
        $this->tipoAfiliadoModel = new TipoAfiliado();
        parent::__construct($this->tipoAfiliadoModel);
    }
}
