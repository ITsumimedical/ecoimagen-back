<?php

namespace App\Http\Modules\Sedes\Repositories;

use App\Http\Modules\Bases\RepositoryBase;
use App\Http\Modules\Sedes\Models\Sede;

class SedeRepository extends RepositoryBase {

    protected $sedeModel;

    public function __construct(){
        $this->sedeModel = new Sede();
        parent::__construct($this->sedeModel);
    }

    public function consultarSede($rep_id){
        return $this->sedeModel->where('rep_id',$rep_id)->first();
    }

}
