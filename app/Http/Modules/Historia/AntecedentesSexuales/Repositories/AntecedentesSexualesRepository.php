<?php

namespace App\Http\Modules\Historia\AntecedentesSexuales\Repositories;

use App\Http\Modules\Bases\RepositoryBase;
use App\Http\Modules\Historia\AntecedentesSexuales\Models\AntecedenteSexuale;

class AntecedentesSexualesRepository extends RepositoryBase {

    public function __construct(protected AntecedenteSexuale $antecedenteSexualeModel) {
    }

    public function listarAntecedentes() {
        return $this->antecedenteSexualeModel::all(['id', 'tipo_antecedentes_sexuales','tipo_orientacion_sexual','tipo_identidad_genero','resultado','cuantos','edad','medico_registra', 'created_at']);
    }
}
