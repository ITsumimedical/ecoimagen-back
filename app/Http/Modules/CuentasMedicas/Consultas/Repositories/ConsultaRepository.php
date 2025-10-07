<?php

namespace App\Http\Modules\CuentasMedicas\Consultas\Repositories;

use App\Http\Modules\Bases\RepositoryBase;
use App\Http\Modules\Rips\Ac\Models\Ac;

class ConsultaRepository extends RepositoryBase {


    public function __construct(protected Ac $ac) {
        parent::__construct($this->ac);
    }

    public function conciliar($id_af){
        $valorPersisten = [];
        $id_glosas = [];
        $ac = $this->ac::select('glosas.id as glosa_id','radicacion_glosa_sumimedicals.valor_no_aceptado')
        ->join('glosas','acs.id','glosas.ac_id')
        ->join('radicacion_glosa_sumimedicals','glosas.id','radicacion_glosa_sumimedicals.glosa_id')
        ->whereIn('acs.af_id',$id_af)
        ->where('radicacion_glosa_sumimedicals.estado_id',1)
        ->get();
        foreach ($ac as $key) {
            $valorPersisten[] = $key->valor_no_aceptado;
            $id_glosas[] = $key->glosa_id;
        }
        return ['valorPersisten'=>$valorPersisten,'id_glosas'=>$id_glosas];
    }

    public function conciliarConSaldo($id_af){
        $valorPersisten = [];
        $id_glosas = [];
        $ac = $this->ac::select('glosas.id as glosa_id','radicacion_glosa_sumimedicals.valor_no_aceptado')
        ->join('glosas','acs.id','glosas.ac_id')
        ->join('radicacion_glosa_sumimedicals','glosas.id','radicacion_glosa_sumimedicals.glosa_id')
        ->whereIn('acs.af_id',$id_af)
        ->where('radicacion_glosa_sumimedicals.estado_id',20)
        ->get();
        foreach ($ac as $key) {
            $valorPersisten[] = $key->valor_no_aceptado;
            $id_glosas[] = $key->glosa_id;
        }
        return ['valorPersisten'=>$valorPersisten,'id_glosas'=>$id_glosas];
    }

}
