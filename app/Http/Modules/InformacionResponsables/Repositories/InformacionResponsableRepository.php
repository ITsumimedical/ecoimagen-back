<?php

namespace App\Http\Modules\InformacionResponsables\Repositories;

use App\Http\Modules\Bases\RepositoryBase;
use App\Http\Modules\InformacionResponsables\Models\InformacionResponsable;

class InformacionResponsableRepository extends RepositoryBase
{
    private $informacionResponsableModel;

    public function __construct()
    {
        $this->informacionResponsableModel = new InformacionResponsable();
        parent::__construct($this->informacionResponsableModel);
    }
}
