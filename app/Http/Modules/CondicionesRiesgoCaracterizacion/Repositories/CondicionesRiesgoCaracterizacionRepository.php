<?php

namespace App\Http\Modules\CondicionesRiesgoCaracterizacion\Repositories;
use App\Http\Modules\Bases\RepositoryBase;
use App\Http\Modules\CondicionesRiesgoCaracterizacion\Models\CondicionesRiesgoCaracterizacion;

class CondicionesRiesgoCaracterizacionRepository extends RepositoryBase
{
    protected $condicionRiesgoCaracterizacionModel;

    public function __construct()
    {
        $this->condicionRiesgoCaracterizacionModel = new CondicionesRiesgoCaracterizacion();
        parent::__construct($this->condicionRiesgoCaracterizacionModel);
    }

    public function listarTodas()
    {
        return $this->condicionRiesgoCaracterizacionModel->all();
    }
}