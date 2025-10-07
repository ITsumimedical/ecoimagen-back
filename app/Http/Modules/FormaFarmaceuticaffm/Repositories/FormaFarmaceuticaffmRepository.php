<?php

namespace App\Http\Modules\FormaFarmaceuticaffm\Repositories;

use App\Http\Modules\Bases\RepositoryBase;
use App\Http\Modules\FormaFarmaceuticaffm\Model\FormaFarmaceuticaffm;

class FormaFarmaceuticaffmRepository extends RepositoryBase {

    public function __construct(protected FormaFarmaceuticaffm $formaFarmaceuticaffm)
    {
        parent::__construct($this->formaFarmaceuticaffm);
    }

}
