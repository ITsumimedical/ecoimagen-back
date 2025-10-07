<?php

namespace App\Http\Modules\Aspirantes\Repositories;

use App\Http\Modules\Aspirantes\Models\Aspirante;
use App\Http\Modules\Bases\RepositoryBase;

class AspiranteRepository extends RepositoryBase {

    private $aspiranteModel;

    public function __construct(Aspirante $aspiranteModel) {
        parent::__construct($aspiranteModel);
        $this->aspiranteModel = $aspiranteModel;
    }
}
