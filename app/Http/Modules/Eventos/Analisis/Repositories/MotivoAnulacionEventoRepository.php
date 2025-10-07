<?php

namespace App\Http\Modules\Eventos\Analisis\Repositories;

use App\Http\Modules\Bases\RepositoryBase;
use App\Http\Modules\Eventos\Analisis\Models\MotivoAnulacionEvento;

class MotivoAnulacionEventoRepository extends RepositoryBase {

    protected $motivoAnulacionModel;

    public function __construct() {
        $this->motivoAnulacionModel = new MotivoAnulacionEvento();
        parent::__construct($this->motivoAnulacionModel);
    }

}
