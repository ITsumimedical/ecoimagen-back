<?php

namespace App\Http\Modules\PqrsfCanales\Repositories;

use App\Http\Modules\Bases\RepositoryBase;
use App\Http\Modules\PqrsfCanales\Models\PqrsfCanal;

class PqrsfCanalRepository extends RepositoryBase {
    protected $model;

    public function __construct() {
        $this->model = new PqrsfCanal();
        parent::__construct($this->model);
    }
}