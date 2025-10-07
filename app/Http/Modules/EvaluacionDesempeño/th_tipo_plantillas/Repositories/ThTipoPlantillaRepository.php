<?php

namespace App\Http\Modules\EvaluacionDesempeño\th_tipo_plantillas\Repositories;

use App\Http\Modules\Bases\RepositoryBase;
use App\Http\Modules\EvaluacionDesempeño\th_tipo_plantillas\Models\ThTipoPlantilla;

class ThTipoPlantillaRepository extends RepositoryBase {


    protected $ThTipoPlantillaModel;

    public function __construct(ThTipoPlantilla $ThTipoPlantillaModel) {
        parent::__construct($ThTipoPlantillaModel);
        $this->ThTipoPlantillaModel = $ThTipoPlantillaModel;
    }

}
