<?php

namespace App\Http\Modules\unidadesMedidasMedicamentos\Repositories;

use App\Http\Modules\Bases\RepositoryBase;
use App\Http\Modules\unidadesMedidasMedicamentos\Model\UnidadesMedidasMedicamentos;

class UnidadesMedidasMedicamentosRepository extends RepositoryBase {

    public function __construct(protected UnidadesMedidasMedicamentos $unidadesMedidasMedicamentos)
    {
        parent::__construct($this->unidadesMedidasMedicamentos);
    }

}
