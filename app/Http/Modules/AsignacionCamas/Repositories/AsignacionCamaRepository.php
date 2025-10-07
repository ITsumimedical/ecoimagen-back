<?php

namespace App\Http\Modules\AsignacionCamas\Repositories;

use App\Http\Modules\AsignacionCamas\Models\AsignacionCama;
use App\Http\Modules\Bases\RepositoryBase;


class AsignacionCamaRepository extends RepositoryBase
{

    public function __construct(protected AsignacionCama $asignacionCamaModel)
    {
        parent::__construct($this->asignacionCamaModel);
    }
}
