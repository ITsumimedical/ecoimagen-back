<?php

namespace App\Http\Modules\EvaluacionDesempeño\th_competencias\Repositories;

use App\Http\Modules\Bases\RepositoryBase;
use App\Http\Modules\EvaluacionDesempeño\th_competencias\Models\ThCompetencia;

class ThCompetenciaRepository extends RepositoryBase {

    protected $ThCompetenciaModel;

    public function __construct(ThCompetencia $ThCompetenciaModel) {
        parent::__construct($ThCompetenciaModel);
        $this->ThCompetenciaModel = $ThCompetenciaModel;
    }

}
