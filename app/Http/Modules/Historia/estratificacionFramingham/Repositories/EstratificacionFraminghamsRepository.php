<?php

namespace App\Http\Modules\Historia\estratificacionFramingham\Repositories;

use App\Http\Modules\Bases\RepositoryBase;
use App\Http\Modules\Historia\estratificacionFramingham\Models\EstratificacionFraminghams;

class EstratificacionFraminghamsRepository extends RepositoryBase {

    public function __construct(protected EstratificacionFraminghams $estratificacionFraminghamModel) {
        parent::__construct($this->estratificacionFraminghamModel);
    }

    public function listarEstratificacion($consulta_id)
    {
        $framighan = EstratificacionFraminghams::select(
            'edad_puntaje',
            'colesterol_total',
            'colesterol_puntaje',
            'colesterol_hdl',
            'colesterol_puntajehdl',
            'fumador_puntaje',
            'arterial_puntaje',
            'totales',
            'tratamiento',
            'porcentaje'
        )
            ->where('estratificacion_framinghams.consulta_id', $consulta_id['consulta_id'])
            ->first();
        return $framighan;
    }

    public function crearFramingham($data)
    {
        $this->estratificacionFraminghamModel::updateOrCreate(['consulta_id' => $data['consulta_id']], $data);
    }
}
