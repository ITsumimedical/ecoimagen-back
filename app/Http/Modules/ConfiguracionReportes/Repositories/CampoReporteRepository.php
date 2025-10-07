<?php

namespace App\Http\Modules\ConfiguracionReportes\Repositories;

use App\Http\Modules\Bases\RepositoryBase;
use App\Http\Modules\ConfiguracionReportes\Models\CampoReporte;

class CampoReporteRepository extends RepositoryBase {

    public function __construct(CampoReporte $model)
    {
        parent::__construct($model);
    }

    public function buscarPor(array $criterios)
    {
        return $this->model->where($criterios)->get();
    }

}
