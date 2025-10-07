<?php

namespace App\Http\Modules\Homologo\Repositories;

use App\Http\Modules\Bases\RepositoryBase;
use App\Http\Modules\Homologo\Models\Homologo;

class HomologoRepository extends RepositoryBase{

    protected $Model;

    public function __construct(){
        $this->Model = new Homologo();
        parent::__construct($this->Model);
    }

    /**
     * Lista homologo
     * @param Object $data
     * @return Collection
     * @author kobatime
     */
    public function listarHomologo($request){
        $consulta = $this->model
        ->with('tipoManual')
        ->whereAnio($request->anio)
        ->whereManual($request->manual_id)
        ->whereCodigo($request->codigo_cups)
        ->orderBy('anio','desc');

        return $request->page ? $consulta->paginate() : $consulta->get();
    }
}
