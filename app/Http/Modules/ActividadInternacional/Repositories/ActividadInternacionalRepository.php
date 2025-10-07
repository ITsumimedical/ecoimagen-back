<?php

namespace App\Http\Modules\ActividadInternacional\Repositories;

use App\Http\Modules\ActividadInternacional\Models\ActividadInternacional;
use App\Http\Modules\Bases\RepositoryBase;
use App\Http\Modules\InformacionFinanciera\Models\InformacionFinanciera;

class ActividadInternacionalRepository extends RepositoryBase {

    public function __construct(protected ActividadInternacional $actividadInternacional) {
        parent::__construct($this->actividadInternacional);
    }



}
