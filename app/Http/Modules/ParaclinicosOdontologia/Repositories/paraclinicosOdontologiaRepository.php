<?php

namespace App\Http\Modules\ParaclinicosOdontologia\Repositories;

use App\Http\Modules\Bases\RepositoryBase;
use App\Http\Modules\ParaclinicosOdontologia\Model\paraclinicosOdontologia;

class paraclinicosOdontologiaRepository extends RepositoryBase {

    public function __construct(protected paraclinicosOdontologia $paraclinicos)
    {
        parent::__construct($this->paraclinicos);
    }
}
