<?php

namespace App\Http\Modules\ContratosMedicamentos\Repositories;

use App\Http\Modules\Bases\RepositoryBase;
use App\Http\Modules\ContratosMedicamentos\Models\AdjuntosContratosMedicamentos;

class AdjuntosContratosMedicamentosRepository extends RepositoryBase
{
    protected AdjuntosContratosMedicamentos $adjuntosContratosMedicamentosModel;

    public function __construct()
    {
        $this->adjuntosContratosMedicamentosModel = new AdjuntosContratosMedicamentos();
        parent::__construct($this->adjuntosContratosMedicamentosModel);
    }
}
