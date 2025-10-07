<?php

namespace App\Http\Modules\Historia\Antecedentes\Repositories;

use App\Http\Modules\Bases\RepositoryBase;
use App\Http\Modules\Historia\Antecedentes\Models\Antecedente;

class AntecedenteRepository extends RepositoryBase {

    public function __construct(protected Antecedente $antecedentesModel) {
    }

    public function listarAntecedentes() {
        return $this->antecedentesModel::all(['id', 'antecedentes', 'descripcion', 'created_at']);
    }
}
