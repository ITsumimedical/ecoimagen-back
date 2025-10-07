<?php

namespace App\Http\Modules\Oncologia\AdjuntosOncologicos\Repositories;

use App\Http\Modules\Bases\RepositoryBase;
use App\Http\Modules\Oncologia\AdjuntosOncologicos\Models\AdjuntosOncologico;

class AdjuntoOncologicoRepository extends RepositoryBase {

    public function __construct(protected AdjuntosOncologico $adjuntosOncologico) {
        parent::__construct($this->adjuntosOncologico);
    }

    public function crear($data){
        return $this->adjuntosOncologico->create($data);
    }
}
