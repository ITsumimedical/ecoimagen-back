<?php

namespace App\Http\Modules\NotasEnfermeria\Repositories;

use App\Http\Modules\Bases\RepositoryBase;
use App\Http\Modules\NotasEnfermeria\Models\NotasEnfermeria;

class NotasEnfermeriaRepository extends RepositoryBase
{
    public function __construct(protected NotasEnfermeria $notasEnfermeriaModel){
        parent::__construct($this->notasEnfermeriaModel);
    }

    public function listarNotas($orden_id){
        return $this->notasEnfermeriaModel->select('notas_enfermerias.nota','signos_alarma','cuidados_casa','caso_urgencias','alimentacion','efectos_secundarios',
        'habito_higiene','derechos_deberes','normas_sala_quimioterapia','notas_enfermerias.created_at','notas_enfermerias.id','notas_enfermerias.user_id','empleados.primer_apellido',
        'segundo_apellido','primer_nombre','segundo_nombre')
        ->join('users','users.id','notas_enfermerias.user_id')
        ->join('empleados','empleados.user_id','users.id')
        ->where('orden_id',$orden_id)->get();
    }



}
