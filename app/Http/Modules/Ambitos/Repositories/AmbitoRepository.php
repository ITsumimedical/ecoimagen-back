<?php

namespace App\Http\Modules\Ambitos\Repositories;

use App\Http\Modules\Ambitos\Models\Ambito;
use App\Http\Modules\Bases\RepositoryBase;

class AmbitoRepository extends RepositoryBase
{
    protected $ambitoModel;

    public function __construct(){
        $this->ambitoModel = new Ambito();
        parent::__construct($this->ambitoModel);
    }


}
