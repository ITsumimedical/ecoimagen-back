<?php

namespace App\Http\Modules\TiposCuentasBancarias\Repositories;

use App\Http\Modules\Bases\RepositoryBase;
use App\Http\Modules\TiposCuentasBancarias\Models\TipoCuentaBancaria;

class TipoCuentaBancariaRepository extends RepositoryBase {

    protected $tipoCuentaBancariaRepository;

    public function __construct() {
        $this->tipoCuentaBancariaRepository = new TipoCuentaBancaria();
        parent::__construct($this->tipoCuentaBancariaRepository);
    }
}
