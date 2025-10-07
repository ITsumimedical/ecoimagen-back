<?php

namespace App\Http\Modules\EntidadExamenLaborales\Repositories;

use App\Http\Modules\Bases\RepositoryBase;
use App\Http\Modules\EntidadExamenLaborales\Models\EntidadExamenLaboral;

class EntidadExamenLaboralRepository extends RepositoryBase {

    protected $entidadExamenLaboralModel;

    public function __construct(){
        $entidadExamenLaboralModel = new EntidadExamenLaboral();
        parent::__construct($entidadExamenLaboralModel);
        $this->entidadExamenLaboralModel = $entidadExamenLaboralModel;
     }
}
