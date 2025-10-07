<?php

namespace App\Http\Modules\OrientacionesSexuales\Repositories;

use App\Http\Modules\Bases\RepositoryBase;
use App\Http\Modules\OrientacionesSexuales\Models\OrientacionSexual;

class OrientacionSexualRepository extends RepositoryBase {

    protected $orientacionModel;

    public function __construct() {
        $this->orientacionModel = new OrientacionSexual();
        parent::__construct($this->orientacionModel);
    }

}
