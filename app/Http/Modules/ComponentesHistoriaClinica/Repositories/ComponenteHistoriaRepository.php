<?php

namespace App\Http\Modules\ComponentesHistoriaClinica\Repositories;

use App\Http\Modules\Bases\RepositoryBase;
use App\Http\Modules\ComponentesHistoriaClinica\Model\ComponentesHistoriaClinica;

class ComponenteHistoriaRepository extends RepositoryBase {

    public function __construct(protected ComponentesHistoriaClinica $componentesHistoriaClinica)
    {
        parent::__construct($this->componentesHistoriaClinica);
    }

    public function listarComponentesEscalas()
    {
        return $this->componentesHistoriaClinica::where('escala', true)->get();
    }

}
