<?php

namespace App\Http\Modules\TipoTest\Repositories;

use App\Http\Modules\Bases\RepositoryBase;
use App\Http\Modules\TipoTest\Model\tipoTest;

class tipoTestRepository extends RepositoryBase {

    public function __construct(protected tipoTest $tipoTest)
    {
        parent::__construct($this->tipoTest);
    }
}
