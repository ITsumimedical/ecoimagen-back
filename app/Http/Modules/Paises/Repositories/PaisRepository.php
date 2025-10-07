<?php

namespace App\Http\Modules\Paises\Repositories;

use App\Http\Modules\Bases\RepositoryBase;
use App\Http\Modules\Paises\Models\Pais;

class PaisRepository extends RepositoryBase {

    protected $paisModel;

    public function __construct() {
        $this->paisModel = new Pais();
        parent::__construct($this->paisModel);
    }

}
