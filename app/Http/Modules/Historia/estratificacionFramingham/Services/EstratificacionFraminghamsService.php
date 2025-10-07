<?php

namespace App\Http\Modules\Historia\estratificacionFramingham\Services;

use App\Http\Modules\Historia\estratificacionFramingham\Models\EstratificacionFraminghams;

class EstratificacionFraminghamsService {

    public function guardarEstratificacionFramingham($datos) {

        $estratificacion = new EstratificacionFraminghams();
        $estratificacion->tratamiento = $datos['tratamiento'];
        $estratificacion->edad_puntaje = $datos['edad_puntaje'];
        $estratificacion->colesterol_total = $datos['colesterol_total'];
        $estratificacion->colesterol_puntaje = $datos['colesterol_puntaje'];
        $estratificacion->colesterol_hdl = $datos['colesterol_hdl'];
        $estratificacion->colesterol_puntajehdl = $datos['colesterol_puntajehdl'];
        $estratificacion->fumador_puntaje = $datos['fumador_puntaje'];
        $estratificacion->arterial_puntaje = $datos['arterial_puntaje'];
        $estratificacion->totales = $datos['totales'];
        $estratificacion->usuario_id = auth()->id();
        $estratificacion->afiliado_id = $datos['afiliado_id'];
        $estratificacion->consulta_id = $datos['consulta_id'];
        $estratificacion->estado_id = 1;
        $estratificacion->diabetes_puntaje = $datos['diabetes_puntaje'];
        $estratificacion->porcentaje = $datos['porcentaje'];
        $estratificacion->save();

    }
}
