<?php

namespace App\Http\Modules\Juzgados\Repositories;

use App\Http\Modules\Bases\RepositoryBase;
use App\Http\Modules\Juzgados\Models\Juzgado;

class JuzgadoRepository extends RepositoryBase{

    protected $juzgadoModel;

    public function __construct(Juzgado $juzgadoModel)
    {
        parent::__construct($juzgadoModel);
        $this->juzgadoModel = $juzgadoModel;
    }

    public function listarJuzgado($data){
        $juzgado = $this->juzgadoModel::select('nombre','estado','id');
        if($data['nombre']){
            $juzgado->where('nombre','ILIKE','%'.$data['nombre'].'%');
        }
        $return = $data->page ? $juzgado->paginate($data->cant) : $juzgado->get();
        return $return;
    }
}
