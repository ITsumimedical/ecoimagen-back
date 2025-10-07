<?php

namespace App\Http\Modules\Subregion\Repositories;

use App\Http\Modules\Bases\RepositoryBase;
use App\Http\Modules\Subregion\Models\Subregiones;

class SubregionRepository extends RepositoryBase{

    protected $Model;

    public function __construct(){
        $this->Model = new Subregiones();
        parent::__construct($this->Model);
    }
}
