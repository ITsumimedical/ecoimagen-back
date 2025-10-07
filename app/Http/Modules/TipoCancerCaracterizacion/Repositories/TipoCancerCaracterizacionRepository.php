<?php

namespace App\Http\Modules\TipoCancerCaracterizacion\Repositories;

use App\Http\Modules\Bases\RepositoryBase;
use App\Http\Modules\TipoCancerCaracterizacion\Models\TipoCancerCaracterizacion;

class TipoCancerCaracterizacionRepository extends RepositoryBase
{

    protected $tipoCancerModel;


    public function __construct()
    {
        $this->tipoCancerModel = new TipoCancerCaracterizacion();
        parent::__construct($this->tipoCancerModel);
    }


    public function listarTodas()
    {
        return $this->tipoCancerModel->all();
    }
}
