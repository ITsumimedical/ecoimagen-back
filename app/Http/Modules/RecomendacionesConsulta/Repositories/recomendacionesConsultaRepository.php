<?php

namespace App\Http\Modules\RecomendacionesConsulta\Repositories;

use App\Http\Modules\Bases\RepositoryBase;
use App\Http\Modules\RecomendacionesConsulta\Model\RecomendacionesConsulta;

class recomendacionesConsultaRepository extends RepositoryBase {

    public function __construct(protected RecomendacionesConsulta $recomendacionesConsulta)
    {
        parent::__construct($this->recomendacionesConsulta);
    }


    public function listarRecomendacion($consulta_id) {
        return  $this->recomendacionesConsulta->select('recomendaciones_consultas.id','recomendaciones_consultas.consulta_id','recomendaciones_consultas.recomendaciones', 'recomendaciones_consultas.user_registra_id',
        'recomendaciones_consultas.estado_id')
        ->join('consultas', 'recomendaciones_consultas.consulta_id', 'consultas.id')
        ->where('consultas.id', $consulta_id)
        ->join('users', 'recomendaciones_consultas.user_registra_id','users.id')
        ->get();
    }
}
