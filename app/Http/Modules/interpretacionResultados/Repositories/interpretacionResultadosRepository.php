<?php

namespace App\Http\Modules\interpretacionResultados\Repositories;

use App\Http\Modules\Bases\RepositoryBase;
use App\Http\Modules\interpretacionResultados\Model\interpretacionResultados;

class interpretacionResultadosRepository extends RepositoryBase {

    public function __construct(protected interpretacionResultados $interpretacionResultados)
    {
        parent::__construct($this->interpretacionResultados);
    }
}
