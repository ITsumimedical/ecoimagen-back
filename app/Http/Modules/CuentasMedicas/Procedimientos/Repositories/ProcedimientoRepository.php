<?php

namespace App\Http\Modules\CuentasMedicas\Procedimientos\Repositories;

use App\Http\Modules\Bases\RepositoryBase;
use App\Http\Modules\Rips\Ap\Models\Ap;

class ProcedimientoRepository extends RepositoryBase {



    public function __construct(protected Ap $ap) {
        parent::__construct($this->ap);
    }

    public function conciliar($id_af){
        $valorPersisten = [];
        $id_glosas = [];

        $ac = $this->ap::select('glosas.id as glosa_id','radicacion_glosa_sumimedicals.valor_no_aceptado')
        ->join('glosas','aps.id','glosas.ap_id')
        ->join('radicacion_glosa_sumimedicals','glosas.id','radicacion_glosa_sumimedicals.glosa_id')
        ->whereIn('aps.af_id',$id_af)
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

        $ac = $this->ap::select('glosas.id as glosa_id','radicacion_glosa_sumimedicals.valor_no_aceptado')
        ->join('glosas','aps.id','glosas.ap_id')
        ->join('radicacion_glosa_sumimedicals','glosas.id','radicacion_glosa_sumimedicals.glosa_id')
        ->whereIn('aps.af_id',$id_af)
        ->where('radicacion_glosa_sumimedicals.estado_id',20)
        ->get();

        foreach ($ac as $key) {
            $valorPersisten[] = $key->valor_no_aceptado;
            $id_glosas[] = $key->glosa_id;
        }


        return ['valorPersisten'=>$valorPersisten,'id_glosas'=>$id_glosas];
    }


}
