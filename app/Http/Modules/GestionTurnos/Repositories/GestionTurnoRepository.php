<?php

namespace App\Http\Modules\GestionTurnos\Repositories;

use App\Http\Modules\Base\RepositoryBase;
use App\Http\Modules\GestionTurnos\Models\GestionTurno;

class GestionTurnoRepository extends RepositoryBase {

    protected $model;

    function __construct(){
        $this->model = new GestionTurno();
        parent::__construct($this->model);
    }
}
