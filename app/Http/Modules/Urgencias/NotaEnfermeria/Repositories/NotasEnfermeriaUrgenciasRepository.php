<?php

namespace App\Http\Modules\Urgencias\NotaEnfermeria\Repositories;


use App\Http\Modules\Bases\RepositoryBase;
use App\Http\Modules\Urgencias\NotaEnfermeria\Models\NotasEnfermeriaUrgencia;

class NotasEnfermeriaUrgenciasRepository extends RepositoryBase
{

    public function __construct(protected NotasEnfermeriaUrgencia $notasEnfermeria)
    {
        parent::__construct($this->notasEnfermeria);
    }

    public function listarNota($data){
        return $this->notasEnfermeria::where('admision_urgencia_id',$data['admision_urgencia_id'])->with('usuario:id','usuario.operador:id,user_id,nombre,apellido')->get();
    }

    public function actualizarNota(int $id,$data){
        return $this->notasEnfermeria::where('id',$id)->update($data);
    }

}
