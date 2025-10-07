<?php

namespace App\Http\Modules\Historia\Paraclinicos\Repositories;

use App\Http\Modules\Bases\RepositoryBase;
use App\Http\Modules\Historia\Paraclinicos\Models\Paraclinico;

class ParaclinicoRepository extends RepositoryBase {

    public function __construct(protected Paraclinico $paraclinico) {
    }

    public function listarParaclinico($consulta_id)
    {
        $paraclinico = Paraclinico::select(
            'fechaColesterol',
            'fechaHdl',
            'fechaTrigliceridos',
            'ultimaCreatinina',
            'resultadoCreatinina',
            'resultadoColesterol',
            'resultadoHdl',
            'resultaGlicosidada',
            'fechaAlbuminuria',
            'fechaGlicosidada',
            'fechaGlicemia',
            'fechaPht',
            'fechaAlbumina',
            'fechaFosforo',
        )
            ->where('paraclinicos.consulta_id', $consulta_id['consulta_id'])
            ->orderBy('paraclinicos.id', 'desc')->first();
        return response()->json($paraclinico, 200);
    }
}
