<?php

namespace App\Http\Modules\Beneficios\Repositories;

use App\Http\Modules\Bases\RepositoryBase;
use App\Http\Modules\Beneficios\Models\Beneficio;

class BeneficiosRepository extends RepositoryBase {

    protected $beneficioModel;

    public function __construct(){
       $beneficioModel = new Beneficio();
       parent::__construct($beneficioModel);
       $this->beneficioModel = $beneficioModel;
    }
}
