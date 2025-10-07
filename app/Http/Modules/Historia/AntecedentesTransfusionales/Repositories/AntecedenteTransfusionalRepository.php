<?php

namespace App\Http\Modules\Historia\AntecedentesTransfusionales\Repositories;

use App\Http\Modules\Bases\RepositoryBase;
use App\Http\Modules\Historia\AntecedentesTransfusionales\Models\AntecedenteTransfusionale;

class AntecedenteTransfusionalRepository extends RepositoryBase {

    public function __construct(protected AntecedenteTransfusionale $antecedenteTransfusional) {
    }

    public function listarAntecedentes($data) {
        return $this->antecedenteTransfusional::with('consulta','user')->whereHas('consulta.afiliado', function ($q) use ($data) {
            $q->where('afiliados.id', $data->afiliado);
        })->get();
    }
}
