<?php

namespace App\Http\Modules\Historia\EscalaAbreviadaDesarrollos\Repositories;

use App\Http\Modules\Bases\RepositoryBase;
use App\Http\Modules\Historia\EscalaAbreviadaDesarrollos\Models\EscalaAbreviadaDesarrollo;

class EscalaAbreviadaDesarrolloRepository extends RepositoryBase
{
    public function __construct(protected EscalaAbreviadaDesarrollo $escalaAbreviadaDesarrollo)
    {
        parent::__construct($this->escalaAbreviadaDesarrollo);
    }

    public function listarEscala($id){
        return $this->escalaAbreviadaDesarrollo->where('consulta_id',$id)->get();
    }

}
