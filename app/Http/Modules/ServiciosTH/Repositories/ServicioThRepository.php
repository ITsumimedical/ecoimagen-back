<?php

namespace App\Http\Modules\ServiciosTH\Repositories;

use App\Http\Modules\Bases\RepositoryBase;
use App\Http\Modules\ServiciosTH\Models\ServicioTh;

class ServicioThRepository extends RepositoryBase {

    protected $servicioThModel;

    public function __construct() {
        $this->servicioThModel = new ServicioTh();
        parent::__construct($this->servicioThModel);
    }
}
