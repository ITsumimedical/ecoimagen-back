<?php

namespace App\Http\Modules\AdjuntoSarlaft\Repositories;

use App\Http\Modules\AdjuntoSarlaft\Models\AdjuntoSarlaft;
use App\Http\Modules\Bases\RepositoryBase;

class AdjuntoSarlaftRepository extends RepositoryBase {

    public function __construct(protected AdjuntoSarlaft $adjuntoSarlaftModel) {
        parent::__construct($this->adjuntoSarlaftModel);
    }

    public function crearAdjunto($ruta,$nombre,$id){
        $this->adjuntoSarlaftModel::create(['ruta'=>$ruta,'nombre'=>$nombre,'sarlaft_id'=>$id]);
    }



}
