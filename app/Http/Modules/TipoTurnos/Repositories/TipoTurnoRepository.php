<?php

namespace App\Http\Modules\TipoTurnos\Repositories;

use App\Http\Modules\Base\RepositoryBase;
use App\Http\Modules\TipoTurnos\Models\TipoTurno;

class TipoTurnoRepository extends RepositoryBase{

    protected $model;

    function __construct(){
        $this->model = new TipoTurno();
        parent::__construct($this->model);
    }

}
