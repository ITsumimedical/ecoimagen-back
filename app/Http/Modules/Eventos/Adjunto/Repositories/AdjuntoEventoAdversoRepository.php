<?php

namespace App\Http\Modules\Eventos\Adjunto\Repositories;

use App\Http\Modules\Bases\RepositoryBase;
use App\Http\Modules\Eventos\Adjunto\Models\AdjuntoEventoAdverso;

class AdjuntoEventoAdversoRepository extends RepositoryBase {

    protected $adjuntoEventoModel;

    public function __construct() {
        $this->adjuntoEventoModel = new AdjuntoEventoAdverso();
        parent::__construct($this->adjuntoEventoModel);
    }
}
