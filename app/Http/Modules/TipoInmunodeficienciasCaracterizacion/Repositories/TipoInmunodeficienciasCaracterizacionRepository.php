<?php

namespace App\Http\Modules\TipoInmunodeficienciasCaracterizacion\Repositories;

use App\Http\Modules\Bases\RepositoryBase;
use App\Http\Modules\TipoInmunodeficienciasCaracterizacion\Models\TipoInmunodeficienciasCaracterizacion;

class TipoInmunodeficienciasCaracterizacionRepository extends RepositoryBase
{
    protected $tipoInmunodeficienciasCaracterizacion;

    public function __construct(){

        $this->tipoInmunodeficienciasCaracterizacion = new TipoInmunodeficienciasCaracterizacion();
        parent::__construct($this->tipoInmunodeficienciasCaracterizacion);
    }

    public function listarTodas()
    {
        return $this->tipoInmunodeficienciasCaracterizacion->all();
    }
}