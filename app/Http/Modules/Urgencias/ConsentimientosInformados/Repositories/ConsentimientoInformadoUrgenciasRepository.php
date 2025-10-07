<?php

namespace App\Http\Modules\Urgencias\ConsentimientosInformados\Repositories;


use App\Http\Modules\Bases\RepositoryBase;
use App\Http\Modules\Urgencias\ConsentimientosInformados\Models\ConsentimientosInformadosUrgencias;

class ConsentimientoInformadoUrgenciasRepository extends RepositoryBase
{

    public function __construct(protected ConsentimientosInformadosUrgencias $consentimientos_informados_urgencias)
    {
        parent::__construct($this->consentimientos_informados_urgencias);
    }

    public function listarConsentimiento($data){
        return $this->consentimientos_informados_urgencias::where('admision_urgencia_id',$data['admision_urgencia_id'])
        ->with('usuario:id','usuario.operador:id,user_id,nombre,apellido')->get();
    }

    public function actualizarConsentimiento(int $id,$data){
        return $this->consentimientos_informados_urgencias::where('id',$id)->update($data);
    }

}
