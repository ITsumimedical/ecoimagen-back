<?php

namespace App\Http\Modules\TipoPrestador\Repositories;

use App\Http\Modules\Bases\RepositoryBase;
use App\Http\Modules\TipoPrestador\Models\TipoPrestador;

class TipoPrestadorRepository extends RepositoryBase {

    public $modelo;

    public function __construct() {
        $this->modelo = new TipoPrestador();
        parent::__construct($this->modelo);
    }

}
