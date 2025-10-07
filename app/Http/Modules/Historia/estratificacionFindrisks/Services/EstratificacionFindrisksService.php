<?php

namespace App\Http\Modules\Historia\estratificacionFindrisks\Services;

use App\Http\Modules\Historia\estratificacionFindrisks\Models\EstratificacionFindrisks;

class EstratificacionFindrisksService {

    public function guardarEstratificacion($datos) {
        $estratificacion = new EstratificacionFindrisks();
        $estratificacion->usuario_id = auth()->id();
        $estratificacion->consulta_id = $datos['consulta_id'];
        $estratificacion->edad_puntaje = $datos['edad_puntaje'];
        $estratificacion->indice_corporal = $datos['indice_corporal'];
        $estratificacion->perimetro_abdominal = $datos['perimetro_abdominal'];
        $estratificacion->actividad_fisica = $datos['actividad_fisica'];
        $estratificacion->puntaje_fisica = $datos['puntaje_fisica'];
        $estratificacion->frutas_verduras = $datos['frutas_verduras'];
        $estratificacion->hipertension = $datos['hipertension'];
        $estratificacion->resultado_hipertension = $datos['resultado_hipertension'];
        $estratificacion->glucosa = $datos['glucosa'];
        $estratificacion->resultado_glucosa = $datos['resultado_glucosa'];
        $estratificacion->diabetes = $datos['diabetes'];
        $estratificacion->parentezco = $datos['parentezco'];
        $estratificacion->resultado_diabetes = $datos['resultado_diabetes'];
        $estratificacion->totales = $datos['totales'];
        $estratificacion->afiliado_id = $datos['afiliado_id'];
        $estratificacion->resultado = $datos['resultado'];
        $estratificacion->estado_id = 1;
        $estratificacion->save();
    }
}
