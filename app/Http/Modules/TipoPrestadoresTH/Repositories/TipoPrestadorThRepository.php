<?php

namespace App\Http\Modules\TipoPrestadoresTH\Repositories;

use App\Http\Modules\Bases\RepositoryBase;
use App\Http\Modules\TipoPrestadoresTH\Models\TipoPrestadorTh;

class TipoPrestadorThRepository extends RepositoryBase {

    protected $tipoPrestadorThModel;

    public function __construct(){
        $tipoPrestadorThModel = new TipoPrestadorTh();
        parent::__construct($tipoPrestadorThModel);
        $this->tipoPrestadorThModel = $tipoPrestadorThModel;
     }

}
