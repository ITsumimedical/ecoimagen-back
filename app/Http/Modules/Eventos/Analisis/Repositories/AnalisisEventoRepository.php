<?php

namespace App\Http\Modules\Eventos\Analisis\Repositories;

use App\Http\Modules\Bases\RepositoryBase;
use App\Http\Modules\Eventos\Analisis\Models\AnalisisEvento;

class AnalisisEventoRepository extends RepositoryBase {

    protected $analisisEventoModel;

    public function __construct() {
        $this->analisisEventoModel = new AnalisisEvento();
        parent::__construct($this->analisisEventoModel);
    }

}
