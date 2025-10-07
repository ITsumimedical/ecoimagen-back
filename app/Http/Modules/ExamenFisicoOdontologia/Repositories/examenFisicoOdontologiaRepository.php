<?php

namespace App\Http\Modules\ExamenFisicoOdontologia\Repositories;

use App\Http\Modules\Bases\RepositoryBase;
use App\Http\Modules\Consultas\Models\Consulta;
use App\Http\Modules\ExamenFisicoOdontologia\Model\examenFisicoOdontologia;

class examenFisicoOdontologiaRepository extends RepositoryBase {

    public function __construct(protected examenFisicoOdontologia $examenOdontologia)
    {
        parent::__construct($this->examenOdontologia);
    }

    public function crearFisico($data) {
        $consultaExiste = $this->examenOdontologia::where('consulta_id',$data['consulta_id'])->first();
        if($consultaExiste){
            $consultaExiste->update($data);
        }else{
            $this->examenOdontologia->create($data);
        }

        return true;
    }
}
