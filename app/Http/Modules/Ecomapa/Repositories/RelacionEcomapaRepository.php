<?php

namespace App\Http\Modules\Ecomapa\Repositories;

use App\Http\Modules\Bases\RepositoryBase;
use App\Http\Modules\Ecomapa\Models\RelacionEcomapa;

class RelacionEcomapaRepository extends RepositoryBase {

    public function __construct(RelacionEcomapa $model)
    {
        $this->model = $model;
    }
}
