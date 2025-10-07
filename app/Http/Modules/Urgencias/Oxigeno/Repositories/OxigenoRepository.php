<?php

namespace App\Http\Modules\Urgencias\Oxigeno\Repositories;


use App\Http\Modules\Bases\RepositoryBase;
use App\Http\Modules\Urgencias\Oxigeno\Models\Oxigeno;

class OxigenoRepository extends RepositoryBase
{

    public function __construct(protected Oxigeno $oxigeno)
    {
        parent::__construct($this->oxigeno);
    }

    public function listarOxigeno($data){
        return $this->oxigeno::where('admision_urgencia_id',$data['admision_urgencia_id'])
        ->with('usuario:id','usuario.operador:id,user_id,nombre,apellido')->orderBy('id', 'desc')->get();
    }

    public function actualizarOxigeno(int $id, array $data)
    {
        return $this->oxigeno::where('id',$id)->update($data);
    }

}
