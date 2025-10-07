<?php

namespace App\Http\Modules\CuadroTurnos\DetalleProgramacionMensual\Repositories;

use App\Http\Modules\Bases\RepositoryBase;
use App\Http\Modules\CuadroTurnos\DetalleProgramacionMensual\Models\DetalleProgramacionMensualTh;

class DetalleProgramacionMensualRepository extends RepositoryBase {

    protected $detalleProgramacionMensualModel;

    public function __construct() {
        $this->detalleProgramacionMensualModel = new DetalleProgramacionMensualTh();
        parent::__construct($this->detalleProgramacionMensualModel);
    }
}
