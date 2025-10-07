<?php

namespace App\Http\Modules\TipoMetabolicasCaracterizacion\Repositories;

use App\Http\Modules\Bases\RepositoryBase;
use App\Http\Modules\TipoMetabolicasCaracterizacion\Models\TipoMetabolicasCaracterizacion;

class TipoMetabolicasCaracterizacionRepository extends RepositoryBase
{
    protected $tipoMetabolicasModel;

    public function __construct()
    {
        $this->tipoMetabolicasModel = new TipoMetabolicasCaracterizacion();
        parent::__construct($this->tipoMetabolicasModel);
    }

    public function listarTodas()
    {
        return $this->tipoMetabolicasModel->all();
    }
}