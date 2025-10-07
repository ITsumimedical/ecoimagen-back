<?php

namespace App\Http\Modules\UnidadesMedidasDispensacion\Repositories;

use App\Http\Modules\Bases\RepositoryBase;
use App\Http\Modules\UnidadesMedidasDispensacion\Model\UnidadesMedidasDispensacion;

class UnidadesMedidasDispensacionRepository extends RepositoryBase {

    public function __construct(protected UnidadesMedidasDispensacion $unidadesMedidasDispensacion)
    {
        parent::__construct($this->unidadesMedidasDispensacion);
    }

    public function listarMedidas(array $request)
    {
        return $this->unidadesMedidasDispensacion->get();
    }
}
