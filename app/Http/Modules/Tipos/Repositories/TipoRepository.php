<?php

namespace App\Http\Modules\Tipos\Repositories;

use App\Http\Modules\Bases\RepositoryBase;
use App\Http\Modules\Tipos\Models\Tipo;
use App\Http\Modules\TiposContratosTH\Models\TipoContratoTh;

class TipoRepository extends RepositoryBase {


    public function __construct(protected Tipo $tipoModel){
        parent::__construct($this->tipoModel);
    }


    public function buscarNombre($nombre){
        return $this->tipoModel->where('nombre',$nombre)->first();
    }

}
