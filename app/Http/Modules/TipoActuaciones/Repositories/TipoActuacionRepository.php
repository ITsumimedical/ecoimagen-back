<?php

namespace App\Http\Modules\TipoActuaciones\Repositories;

use App\Http\Modules\Bases\RepositoryBase;
use App\Http\Modules\TipoActuaciones\Models\TipoActuacion;

class TipoActuacionRepository extends RepositoryBase{

    protected $tipoActuacionModel;

    public function __construct(TipoActuacion $tipoActuacionModel)
    {
        parent::__construct($tipoActuacionModel);
        $this->tipoActuacionModel = $tipoActuacionModel;
    }

}
