<?php

namespace App\Http\Modules\ExamenTejidosDuros\Repositories;

use App\Http\Modules\Bases\RepositoryBase;
use App\Http\Modules\ExamenTejidosDuros\Model\examenTejidosDuros;

class examenTejidosDurosRepository extends RepositoryBase {

    public function __construct(protected examenTejidosDuros $tejidosDuros)
    {
        parent::__construct($this->tejidosDuros);
    }
}
