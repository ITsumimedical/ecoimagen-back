<?php

namespace App\Http\Modules\CuentasMedicas\Insumos\Repositories;

use App\Http\Modules\Bases\RepositoryBase;
use App\Http\Modules\Rips\At\Models\At;

class InsumoRepository extends RepositoryBase {

    public function __construct(protected At $at) {
        parent::__construct($this->at);
    }

    public function conciliar($id_af){
        $valorPersisten = [];
        $id_glosas = [];

        $at = $this->at::select('glosas.id as glosa_id','radicacion_glosa_sumimedicals.valor_no_aceptado')
        ->join('glosas','ats.id','glosas.at_id')
        ->join('radicacion_glosa_sumimedicals','glosas.id','radicacion_glosa_sumimedicals.glosa_id')
        ->whereIn('ats.af_id',$id_af)
        ->where('radicacion_glosa_sumimedicals.estado_id',1)
        ->get();

        foreach ($at as $key) {
            $valorPersisten[] = $key->valor_no_aceptado;
            $id_glosas[] = $key->glosa_id;
        }

        return ['valorPersisten'=>$valorPersisten,'id_glosas'=>$id_glosas];
    }

    public function conciliarConSaldo($id_af){
        $valorPersisten = [];
        $id_glosas = [];

        $at = $this->at::select('glosas.id as glosa_id','radicacion_glosa_sumimedicals.valor_no_aceptado')
        ->join('glosas','ats.id','glosas.at_id')
        ->join('radicacion_glosa_sumimedicals','glosas.id','radicacion_glosa_sumimedicals.glosa_id')
        ->whereIn('ats.af_id',$id_af)
        ->where('radicacion_glosa_sumimedicals.estado_id',20)
        ->get();

        foreach ($at as $key) {
            $valorPersisten[] = $key->valor_no_aceptado;
            $id_glosas[] = $key->glosa_id;
        }

        return ['valorPersisten'=>$valorPersisten,'id_glosas'=>$id_glosas];
    }



}
