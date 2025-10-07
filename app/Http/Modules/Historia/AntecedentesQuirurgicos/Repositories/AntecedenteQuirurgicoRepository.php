<?php

namespace App\Http\Modules\Historia\AntecedentesQuirurgicos\Repositories;

use App\Http\Modules\Bases\RepositoryBase;
use App\Http\Modules\Historia\AntecedentesQuirurgicos\Models\AntecedenteQuirurgico;

class AntecedenteQuirurgicoRepository extends RepositoryBase {

    public function __construct(protected AntecedenteQuirurgico $antecedenteQuirurgicoModel) {
    }

    public function listarAntecedentes($data) {
        return $this->antecedenteQuirurgicoModel::with('consulta','user.operador')->whereHas('consulta.afiliado', function ($q) use ($data) {
            $q->where('afiliados.id', $data->afiliado);
        })->get();
    }

    public function crear($data)
    {
        return $this->antecedenteQuirurgicoModel->create($data);
    }
}
