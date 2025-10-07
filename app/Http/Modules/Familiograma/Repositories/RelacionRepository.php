<?php

namespace App\Http\Modules\Familiograma\Repositories;

use App\Http\Modules\Bases\RepositoryBase;
use App\Http\Modules\Familiograma\Models\Relacione;

class RelacionRepository extends RepositoryBase
{

    public function __construct(Relacione $model)
    {
        $this->model = $model;
    }
}
