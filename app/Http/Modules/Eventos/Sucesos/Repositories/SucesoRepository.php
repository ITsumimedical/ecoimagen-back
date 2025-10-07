<?php

namespace App\Http\Modules\Eventos\Sucesos\Repositories;

use App\Http\Modules\Bases\RepositoryBase;
use App\Http\Modules\Eventos\Sucesos\Models\Suceso;

class SucesoRepository extends RepositoryBase {

    protected $sucesoModel;

    public function __construct(){
       $sucesoModel = new Suceso();
       parent::__construct($sucesoModel);
       $this->sucesoModel = $sucesoModel;
    }

}
