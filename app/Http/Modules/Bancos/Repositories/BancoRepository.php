<?php

namespace App\Http\Modules\Bancos\Repositories;

use App\Http\Modules\Bancos\Models\Banco;
use App\Http\Modules\Bases\RepositoryBase;

class BancoRepository extends RepositoryBase {

    protected $bancoModel;

    public function __construct() {
        $this->bancoModel = new Banco();
        parent::__construct($this->bancoModel);
    }
}
