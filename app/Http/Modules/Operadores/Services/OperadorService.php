<?php

namespace App\Http\Modules\Operadores\Services;

use App\Http\Modules\Operadores\Models\Operadore;

class OperadorService
{
    public function __construct(
        protected Operadore $operadorModel,
    ) {
    }

    public function listarConFiltros($request) {

        return $this->operadorModel->WhereNombre($request->nombre)->get();

    }

    
}
