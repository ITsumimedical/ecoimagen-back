<?php

namespace App\Http\Modules\AntecedentesOdontologicos\Repositories;

use App\Http\Modules\AntecedentesOdontologicos\Model\antecedentesOdontologicos;
use App\Http\Modules\Bases\RepositoryBase;

class antecedentesOdontologicosRepository extends RepositoryBase {

    public function __construct(protected antecedentesOdontologicos $antecedentesModel)
    {
        parent::__construct($this->antecedentesModel);
    }
}
