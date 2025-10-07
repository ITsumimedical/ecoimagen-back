<?php

namespace App\Http\Modules\ManualTarifario\Repositories;

use App\Http\Modules\Bases\RepositoryBase;
use App\Http\Modules\ManualTarifario\Models\ManualTarifario;

class ManualTarifarioRepository extends RepositoryBase {

    public $model;

    public function __construct(){
        $this->model = new ManualTarifario();
        parent::__construct($this->model);
    }

}