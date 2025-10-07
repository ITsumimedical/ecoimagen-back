<?php

namespace App\Http\Modules\InformacionFinanciera\Repositories;

use App\Http\Modules\Bases\RepositoryBase;
use App\Http\Modules\InformacionFinanciera\Models\InformacionFinanciera;

class InformacionFinancieraRepository extends RepositoryBase {

    public function __construct(protected InformacionFinanciera $informacionFinancieraModel) {
        parent::__construct($this->informacionFinancieraModel);
    }



}
