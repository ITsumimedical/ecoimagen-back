<?php

namespace App\Http\Modules\TipoCampo\Repositories;

use App\Http\Modules\Bases\RepositoryBase;
use App\Http\Modules\TipoCampo\Models\TipoCampo;

class TipoCampoRepository extends RepositoryBase {

    protected $tipoCampoModel;

    public function __construct()
    {
        $this->tipoCampoModel = new TipoCampo();
        parent::__construct($this->tipoCampoModel);
    }

}
