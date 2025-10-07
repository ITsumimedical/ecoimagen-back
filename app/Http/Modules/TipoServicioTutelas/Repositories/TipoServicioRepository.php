<?php

namespace App\Http\Modules\TipoServicioTutelas\Repositories;

use App\Http\Modules\Bases\RepositoryBase;
use App\Http\Modules\TipoServicioTutelas\Models\TipoServicioTutela;

class TipoServicioRepository extends RepositoryBase{

    protected $tipoServicioModel;

    function __construct(){
        $this->tipoServicioModel = new TipoServicioTutela();
        parent::__construct($this->tipoServicioModel);
    }
}
