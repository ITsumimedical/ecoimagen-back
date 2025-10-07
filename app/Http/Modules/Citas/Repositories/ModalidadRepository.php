<?php

namespace App\Http\Modules\Citas\Repositories;

use App\Http\Modules\Bases\RepositoryBase;
use App\Http\Modules\Citas\Models\Modalidad;

class ModalidadRepository extends RepositoryBase
{
    protected $modalidadModel;

    public function __construct()
    {
        $this->modalidadModel = new Modalidad();
        parent::__construct($this->modalidadModel);
    }
}
