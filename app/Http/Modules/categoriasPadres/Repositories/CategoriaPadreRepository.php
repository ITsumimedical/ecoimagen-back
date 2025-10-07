<?php

namespace App\Http\Modules\categoriasPadres\Repositories;

use App\Http\Modules\Bases\RepositoryBase;
use App\Http\Modules\categoriasPadres\Models\CategoriaPadre;

class CategoriaPadreRepository extends RepositoryBase {

    protected $categoriaPadreModel;

    public function __construct() {
        $this->categoriaPadreModel = new CategoriaPadre();
        parent::__construct($this->categoriaPadreModel);
    }
}
