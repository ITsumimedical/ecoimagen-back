<?php

namespace App\Http\Modules\TurnosTH\Repositories;

use App\Http\Modules\Bases\RepositoryBase;
use App\Http\Modules\TurnosTH\Models\TurnoTh;

class TurnoThRepository extends RepositoryBase {

    protected $turnoThModel;

    public function __construct(){
        $turnoThModel = new TurnoTh();
        parent::__construct($turnoThModel);
        $this->turnoThModel = $turnoThModel;
     }

}
