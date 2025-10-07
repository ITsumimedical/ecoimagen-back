<?php

namespace App\Http\Modules\PersonalExpuesto\Repositories;

use App\Http\Modules\Bases\RepositoryBase;
use App\Http\Modules\PersonalExpuesto\Models\PersonalExpuesto;

class PersonalExpuestoRepository extends RepositoryBase {

    public function __construct(protected PersonalExpuesto $personalExpuestoModel) {
        parent::__construct($this->personalExpuestoModel);
    }

    public function listarPersonal($data){
        return $this->personalExpuestoModel::where('sarlaft_id',$data->sarlaft_id)->where('estado_id',1)->get();

    }

    public function inactivar($data){
        $this->personalExpuestoModel::find($data['id'])->update(['estado_id'=>2]);

    }

}
