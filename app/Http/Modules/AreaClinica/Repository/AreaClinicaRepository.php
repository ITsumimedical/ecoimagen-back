<?php

namespace App\Http\Modules\AreaClinica\Repository;

use App\Http\Modules\AreaClinica\Models\AreaClinica;
use App\Http\Modules\Base\RepositoryBase;

class AreaClinicaRepository extends RepositoryBase {

    public $model;

    public function __construct(){
        $this->model = new AreaClinica();
    }

}