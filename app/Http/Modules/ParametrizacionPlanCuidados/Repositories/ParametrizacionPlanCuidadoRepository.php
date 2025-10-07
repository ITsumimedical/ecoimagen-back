<?php

namespace App\Http\Modules\ParametrizacionPlanCuidados\Repositories;

use App\Http\Modules\Bases\RepositoryBase;
use App\Http\Modules\ParametrizacionPlanCuidados\Models\ParametrizacionPlanCuidado;

class ParametrizacionPlanCuidadoRepository extends RepositoryBase {

    public function __construct(protected ParametrizacionPlanCuidado $parametrizacionPlanCuidado) {
        parent::__construct($this->parametrizacionPlanCuidado);
    }

    public function listarPlanes() {
        return ParametrizacionPlanCuidado::with('articulos','articulos.codesumi')->get();
    }
}
