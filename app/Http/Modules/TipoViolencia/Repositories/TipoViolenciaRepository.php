<?php

namespace App\Http\Modules\TipoViolencia\Repositories;

use App\Http\Modules\Bases\RepositoryBase;
use App\Http\Modules\TipoViolencia\Models\TipoViolencia;

class TipoViolenciaRepository extends RepositoryBase
{
    protected $tipoViolenciaModel;

    public function __construct()
    {
        $this->tipoViolenciaModel = new TipoViolencia();
        parent::__construct($this->tipoViolenciaModel);
    }

    public function listarTodas()
    {
        return $this->tipoViolenciaModel->all();
    }
}
