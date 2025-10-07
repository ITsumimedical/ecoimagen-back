<?php

namespace App\Http\Modules\Historia\estratificacionFindrisks\Repositories;

use App\Http\Modules\Bases\RepositoryBase;
use App\Http\Modules\Historia\estratificacionFindrisks\Models\EstratificacionFindrisks;

class EstratificacionFindrisksRepository extends RepositoryBase {

    public function __construct(protected EstratificacionFindrisks $estratificacionModel) {
        parent::__construct($this->estratificacionModel);
    }

    public function listarEstratificacion($consulta_id)
    {
        $findrisk = EstratificacionFindrisks::select(
            'edad_puntaje',
            'indice_corporal',
            'perimetro_abdominal',
            'actividad_fisica',
            'puntaje_fisica',
            'frutas_verduras',
            'hipertension',
            'resultado_hipertension',
            'glucosa',
            'resultado_glucosa',
            'diabetes',
            'parentezco',
            'resultado_diabetes',
            'totales'
        )
            ->where('estratificacion_findrisks.consulta_id', $consulta_id['consulta_id'])
            ->first();
        return $findrisk;
    }

    public function crearFindrisc($data){
        $this->estratificacionModel::updateOrCreate(['consulta_id' => $data['consulta_id']],$data);
    }
}
