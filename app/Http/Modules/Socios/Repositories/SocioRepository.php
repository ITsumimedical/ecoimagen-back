<?php

namespace App\Http\Modules\Socios\Repositories;

use App\Http\Modules\Bases\RepositoryBase;
use App\Http\Modules\Socios\Models\Socios;

class SocioRepository extends RepositoryBase {

    public function __construct(protected Socios $socioModel) {
        parent::__construct($this->socioModel);
    }

    public function listarSocios($data){
        return $this->socioModel::where('sarlaft_id',$data->sarlaft_id)->where('estado_id',1)->get();

    }

    public function inactivar($data){
        $this->socioModel::find($data['id'])->update(['estado_id'=>2]);

    }

}
