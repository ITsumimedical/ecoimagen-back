<?php

namespace App\Http\Modules\PlanTratamiento\Repositories;

use App\Http\Modules\Bases\RepositoryBase;
use App\Http\Modules\PlanTratamiento\Model\planTratamientoOdontologia;

class planTratamientoRepository extends RepositoryBase {

    public function __construct(protected planTratamientoOdontologia $planTratamiento)
    {
        parent::__construct($this->planTratamiento);
    }
}
