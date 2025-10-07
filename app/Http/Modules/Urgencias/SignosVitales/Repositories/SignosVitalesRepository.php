<?php

namespace App\Http\Modules\Urgencias\SignosVitales\Repositories;


use App\Http\Modules\Bases\RepositoryBase;
use App\Http\Modules\Urgencias\SignosVitales\Models\SignosVitales;

class SignosVitalesRepository extends RepositoryBase
{

    public function __construct(protected SignosVitales $signos_vitales)
    {
        parent::__construct($this->signos_vitales);
    }

    public function listarSignosVitales($data){
        return $this->signos_vitales::where('admision_urgencia_id',$data['admision_urgencia_id'])->with('usuario:id','usuario.operador:id,user_id,nombre,apellido')->orderBy('id', 'desc')->get();
    }

    public function actualizarSigno(int $id, array $data){
        return $this->signos_vitales::where('id',$id)->update($data);
    }

}
