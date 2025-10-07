<?php

namespace App\Http\Modules\Patologia\Repositories;

use App\Http\Modules\Bases\RepositoryBase;
use App\Http\Modules\Patologia\Model\AntecedentesPatologias;

class AntecedentesPatologiaRepository extends RepositoryBase {

    protected $antecedente;

    public function __construct() {
        $this->antecedente = new AntecedentesPatologias();
        parent::__construct($this->antecedente);
    }
}
