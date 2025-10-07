<?php

namespace App\Http\Modules\TipoCitas\Repositories;

use App\Http\Modules\Bases\RepositoryBase;
use App\Http\Modules\TipoCitas\Models\TipoCita;

class TipoCitaRepository extends RepositoryBase {

    protected $tipoCitaModel;

    public function __construct() {
        $this->tipoCitaModel = new TipoCita();
        parent::__construct($this->tipoCitaModel);
    }

}
