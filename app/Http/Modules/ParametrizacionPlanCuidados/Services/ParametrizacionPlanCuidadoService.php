<?php

namespace App\Http\Modules\ParametrizacionPlanCuidados\Services;

use App\Http\Modules\ParametrizacionPlanCuidados\Models\ParametrizacionPlanCuidado;
use App\Http\Modules\ParametrizacionPlanCuidados\Models\ParametrizacionPlanCuidadoDetalle;

class ParametrizacionPlanCuidadoService
{
    public function __construct(){

    }

    public function crear($id,$request)
    {
//        dd($request);
        if(intval($id) === 0){
            $planCuidado = ParametrizacionPlanCuidado::create($request['plan']);
        }else{
            $planCuidado = ParametrizacionPlanCuidado::find($id);
            $planCuidado->nombre = $request['plan']['nombre'];
            $planCuidado->descripcion = $request['plan']['descripcion'];
            $planCuidado->save();
            ParametrizacionPlanCuidadoDetalle::where('parametrizacion_plan_cuidado_id',$id)->delete();
        }
        foreach ($request['articulos'] as $articulo) {
//            dd($articulo);
            $detalleParametrizacionPlanCuidado = new ParametrizacionPlanCuidadoDetalle();
            $detalleParametrizacionPlanCuidado->parametrizacion_plan_cuidado_id = $planCuidado->id;
            $detalleParametrizacionPlanCuidado->codesumi_id = $articulo['codesumi']['id'];
            $detalleParametrizacionPlanCuidado->presentacion = $articulo['presentacion'];
            $detalleParametrizacionPlanCuidado->via = $articulo['via'];
            $detalleParametrizacionPlanCuidado->dosis = $articulo['dosis'];
            $detalleParametrizacionPlanCuidado->frecuencia = $articulo['frecuencia'];
            $detalleParametrizacionPlanCuidado->unidad_tiempo = $articulo['unidad_tiempo'];
            $detalleParametrizacionPlanCuidado->duracion = $articulo['duracion'];
            $detalleParametrizacionPlanCuidado->meses = $articulo['meses'];
            $detalleParametrizacionPlanCuidado->cantidad_medico = $articulo['cantidad_medico'];
            $detalleParametrizacionPlanCuidado->observacion = $articulo['observacion'];
            $detalleParametrizacionPlanCuidado->save();
        }
        return "Registro Guardado";
    }
}
