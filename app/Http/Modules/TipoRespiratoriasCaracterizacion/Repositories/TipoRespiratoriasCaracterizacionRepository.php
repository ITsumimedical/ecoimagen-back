<?php

namespace App\Http\Modules\TipoRespiratoriasCaracterizacion\Repositories;

use App\Http\Modules\Bases\RepositoryBase;
use App\Http\Modules\TipoRespiratoriasCaracterizacion\Models\TipoRespiratoriasCaracterizacion;

class TipoRespiratoriasCaracterizacionRepository extends RepositoryBase
{
    protected $tipoRespiratoriasModel;

    public function __construct()
    {
        $this->tipoRespiratoriasModel = new TipoRespiratoriasCaracterizacion();
        parent::__construct($this->tipoRespiratoriasModel);
    }

    public function listarTodas()
    {
        return $this->tipoRespiratoriasModel->all();
    }
}
