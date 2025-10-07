<?php

namespace App\Http\Modules\categorias\Repositories;

use App\Http\Modules\Bases\RepositoryBase;
use App\Http\Modules\categorias\Models\categorias;

class categoriasRepository extends RepositoryBase {


    protected $categorias;

    public function __construct() {
        $this->categorias = new categorias();
        parent::__construct($this->categorias);
    }
}
