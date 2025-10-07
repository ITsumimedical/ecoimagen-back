<?php

namespace App\Http\Modules\EvaluacionDesempeño\th_pilares\Repositories;

use App\Http\Modules\Bases\RepositoryBase;
use App\Http\Modules\EvaluacionDesempeño\th_pilares\Models\ThPilar;

class ThPilarRepository extends RepositoryBase {

    protected $ThPilarModel;

    public function __construct(ThPilar $ThPilarModel) {
        parent::__construct($ThPilarModel);
        $this->ThPilarModel = $ThPilarModel;
    }

}
