<?php

namespace App\Http\Modules\Consultorios\Repositories;

use App\Http\Modules\Bases\RepositoryBase;
use App\Http\Modules\Consultorios\Models\Consultorio;

class ConsultorioRepository extends RepositoryBase
{
    protected $consultorioModel;

    public function __construct() {
        $this->consultorioModel = new Consultorio();
        parent::__construct($this->consultorioModel);
    }

    public function listarRep($rep_id){
        return  $this->consultorioModel->select([
                'consultorios.id',
                'consultorios.nombre',
                'consultorios.cantidad_paciente',
            ])
            ->where('rep_id',$rep_id)
            ->where('estado_id', 1)
            ->get();
    }
}
