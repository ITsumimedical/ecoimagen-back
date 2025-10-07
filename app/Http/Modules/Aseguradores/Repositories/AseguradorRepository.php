<?php

namespace App\Http\Modules\Aseguradores\Repositories;

use App\Http\Modules\Aseguradores\Models\Asegurador;
use App\Http\Modules\Aspirantes\Models\Aspirante;
use App\Http\Modules\Bases\RepositoryBase;

class AseguradorRepository extends RepositoryBase {

    private $Modelo;

    public function __construct() {
        $this->Modelo = new Asegurador();
        parent::__construct($this->Modelo);
    }
}
