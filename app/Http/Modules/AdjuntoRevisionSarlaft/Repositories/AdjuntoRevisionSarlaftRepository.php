<?php

namespace App\Http\Modules\AdjuntoRevisionSarlaft\Repositories;

use App\Http\Modules\AdjuntoRevisionSarlaft\Models\AdjuntoRevisionSarlaft;
use App\Http\Modules\AdjuntoSarlaft\Models\AdjuntoSarlaft;
use App\Http\Modules\Bases\RepositoryBase;

class AdjuntoRevisionSarlaftRepository extends RepositoryBase {

    public function __construct(protected AdjuntoRevisionSarlaft $adjuntoSarlaftModel) {
        parent::__construct($this->adjuntoSarlaftModel);
    }

    public function crearAdjunto($ruta,$nombre,$id){
        $this->adjuntoSarlaftModel::create(['ruta'=>$ruta,'nombre'=>$nombre,'revision_sarlaft_id'=>$id]);
    }



}
