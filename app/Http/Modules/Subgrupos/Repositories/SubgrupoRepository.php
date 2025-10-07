<?php

namespace App\Http\Modules\Subgrupos\Repositories;

use App\Http\Modules\Bases\RepositoryBase;
use App\Http\Modules\Subgrupos\Models\Subgrupo;

class SubgrupoRepository extends RepositoryBase {


    public function __construct(protected Subgrupo $subgrupo) {
        parent::__construct($this->subgrupo);
    }

    public function actualizarGrupo($data,$id){
        $subgrupo = $this->subgrupo::find($id);
        return $subgrupo->update([
            'nombre' => $data['nombre'],
            'descripcion' => $data['descripcion'],
          ]);

    }

}
