<?php

namespace App\Http\Modules\TipoBodega\Repositories;

use App\Http\Modules\Bases\RepositoryBase;
use App\Http\Modules\TipoBodega\Models\TipoBodegas;

class TipoBodegaRepository extends RepositoryBase {

    protected $tipoCampoModel;

    public function __construct()
    {
        $this->tipoCampoModel = new TipoBodegas();
        parent::__construct($this->tipoCampoModel);
    }

}
