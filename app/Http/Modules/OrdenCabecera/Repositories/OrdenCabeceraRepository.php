<?php

namespace App\Http\Modules\OrdenCabecera\Repositories;

use App\Http\Modules\Bases\RepositoryBase;
use App\Http\Modules\OrdenCabecera\Models\OrdenCabecera;
use App\Http\Modules\ResultadoAnnarlabs\Models\ResultadoAnnarlab;

class OrdenCabeceraRepository extends RepositoryBase {


    public function __construct(protected OrdenCabecera $ordenCabecera) {
        parent::__construct($this->ordenCabecera);
    }

    public function listarLaboratorios($data){

        return $this->ordenCabecera::select('orden_cabeceras.num_orden','orden_cabeceras.fecha','orden_cabeceras.nombre_medico',
        'orden_cabeceras.urgente','reps.nombre as rep','orden_detalles.nombre_examen',
        'orden_detalles.codigo_examen','orden_detalles.estado_cargado','orden_detalles.estado_resultado')
        ->join('reps','reps.id','orden_cabeceras.id_laboratorio')
        ->join('orden_detalles','orden_detalles.num_orden','orden_cabeceras.num_orden')
        ->where('orden_cabeceras.documento',$data['cedula'])
        ->distinct()
        ->get();
    }

    public function resultados($data){
        ResultadoAnnarlab::select('resultado_annarlabs.*')
        ->where('resultado_annarlabs.num_orden',$data['num_orden'])
        ->where('resultado_annarlabs.codigo_examen',$data['codigo_examen'])
        ->distinct()
        ->get();
    }


}
