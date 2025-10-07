<?php

namespace App\Http\Modules\ExclusionTutelas\Repositories;

use App\Http\Modules\Bases\RepositoryBase;
use App\Http\Modules\ExclusionTutelas\Models\exclusionesTutela;

class ExclusionTutelasRepository extends RepositoryBase
{
    protected $model;

    public function __construct() {
        $this->model = new exclusionesTutela();
    }

}