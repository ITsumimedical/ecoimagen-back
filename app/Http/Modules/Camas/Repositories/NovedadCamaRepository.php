<?php

namespace App\Http\Modules\Camas\Repositories;

use App\Http\Modules\Bases\RepositoryBase;
use App\Http\Modules\Camas\Models\NovedadesCama;

class NovedadCamaRepository extends RepositoryBase {

    public function __construct(protected NovedadesCama $camaModel)
    {
        parent::__construct($this->camaModel);
    }



}
