<?php

namespace App\Http\Modules\CuentasMedicas\Medicamentos\Repositories;

use App\Http\Modules\Bases\RepositoryBase;
use App\Http\Modules\Rips\Am\Models\Am;

class MedicamentoRepository extends RepositoryBase {


    public function __construct(protected Am $am) {
        parent::__construct($this->am);
    }

    public function conciliar($id_af){
        $valorPersisten = [];
        $id_glosas = [];

        $am = $this->am::select('glosas.id as glosa_id','radicacion_glosa_sumimedicals.valor_no_aceptado')
        ->join('glosas','ams.id','glosas.am_id')
        ->join('radicacion_glosa_sumimedicals','glosas.id','radicacion_glosa_sumimedicals.glosa_id')
        ->whereIn('ams.af_id',$id_af)
        ->where('radicacion_glosa_sumimedicals.estado_id',1)
        ->get();

        foreach ($am as $key) {
            $valorPersisten[] = $key->valor_no_aceptado;
            $id_glosas[] = $key->glosa_id;
        }

        return ['valorPersisten'=>$valorPersisten,'id_glosas'=>$id_glosas];
    }

    public function conciliarConSaldo($id_af){
        $valorPersisten = [];
        $id_glosas = [];

        $am = $this->am::select('glosas.id as glosa_id','radicacion_glosa_sumimedicals.valor_no_aceptado')
        ->join('glosas','ams.id','glosas.am_id')
        ->join('radicacion_glosa_sumimedicals','glosas.id','radicacion_glosa_sumimedicals.glosa_id')
        ->whereIn('ams.af_id',$id_af)
        ->where('radicacion_glosa_sumimedicals.estado_id',20)
        ->get();

        foreach ($am as $key) {
            $valorPersisten[] = $key->valor_no_aceptado;
            $id_glosas[] = $key->glosa_id;
        }

        return ['valorPersisten'=>$valorPersisten,'id_glosas'=>$id_glosas];
    }


}
