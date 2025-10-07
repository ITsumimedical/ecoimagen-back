<?php

namespace App\Http\Modules\InformacionCuidador\Repositories;

use App\Http\Modules\Bases\RepositoryBase;
use App\Http\Modules\InformacionCuidador\Models\InformacionCuidador;

class InformacionCuidadorRepository extends RepositoryBase
{
    private $informacionCuidadorModel;

    public function __construct()
    {
        $this->informacionCuidadorModel =  new InformacionCuidador();
        parent::__construct($this->informacionCuidadorModel);
    }
}
