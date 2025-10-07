<?php

namespace App\Http\Modules\TiposContratosTH\Repositories;

use App\Http\Modules\Bases\RepositoryBase;
use App\Http\Modules\TiposContratosTH\Models\TipoContratoTh;

class TipoContratoThRepository extends RepositoryBase {

    protected $tipoContratoThModel;

    public function __construct(){
       $tipoContratoThModel = new TipoContratoTh();
       parent::__construct($tipoContratoThModel);
       $this->tipoContratoThModel = $tipoContratoThModel;
    }

}
