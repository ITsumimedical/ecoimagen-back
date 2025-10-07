<?php

namespace App\Http\Modules\Grupos\Repositories;

use App\Http\Modules\Bases\RepositoryBase;
use App\Http\Modules\Grupos\Models\Grupo;

class GrupoRepository extends RepositoryBase {


    public function __construct(protected Grupo $grupo) {
        parent::__construct($this->grupo);
    }

    public function actualizarGrupo($data,$id){
        $grupo = $this->grupo::find($id);
        return $grupo->update([
            'nombre' => $data['nombre'],
            'codigo' => $data['codigo'],
          ]);

    }

}
