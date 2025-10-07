<?php

namespace App\Http\Modules\EvaluacionDesempeño\evaluaciones_desempeños\Repositories;

use App\Http\Modules\Bases\RepositoryBase;
use App\Http\Modules\EvaluacionDesempeño\evaluaciones_desempeños\Models\EvaluacionesDesempeno;
use App\Http\Modules\EvaluacionDesempeño\th_pilares\Models\ThPilar;
use App\Http\Modules\EvaluacionDesempeño\th_tipo_plantillas\Models\ThTipoPlantilla;

class EvaluacionesDesempenoRepository extends RepositoryBase {

    protected $evaluacionDesempenoModel;

    public function __construct(EvaluacionesDesempeno $evaluacionDesempenoModel) {
        parent::__construct($evaluacionDesempenoModel);
        $this->evaluacionDesempenoModel = $evaluacionDesempenoModel;
    }
    public function firstOrCreateEvaluacionDesempeno($request)
    {
        $user = EvaluacionesDesempeno::select('evaluaciones_desempenos.id', 'th_tipo_plantillas.nombre',
                                                'cc.calificacion', 'th_competencias.competencia', 'th_competencias.descripcion',
                                                'th_pilars.nombre','th_pilars.porcentaje','th_pilars.orden')
        ->leftjoin('calificacion_competencias as cc', 'evaluaciones_desempenos.id', 'cc.evaluaciones_desempeno_id')
        ->leftjoin('th_competencias', 'cc.th_competencia_id', 'th_competencias.id')
        ->leftjoin('th_pilars', 'th_competencias.th_pilar_id', 'th_pilars.id')
        ->join('th_tipo_plantillas', 'evaluaciones_desempenos.th_tipo_plantilla_id', 'th_tipo_plantillas.id')
        ->where('evaluaciones_desempenos.empleado_id', $request->empleado_id)
        ->where('evaluaciones_desempenos.esta_activo', 1)
        ->where('evaluaciones_desempenos.th_tipo_plantilla_id', $request->th_tipo_plantilla_id)
        ->firstOrCreate([
            'empleado_id' =>  $request->empleado_id
        ], [
            'fecha_inicial_periodo' => $request->fecha_inicial_periodo,
            'fecha_final_periodo' => $request->fecha_final_periodo,
            'th_tipo_plantilla_id' => $request->th_tipo_plantilla_id,
            'empleado_id' =>  $request->empleado_id,
            'evaluador_id' => auth()->id()
        ]);
        return $user;
    }

    public function PlantillaEvaluacion($plantilla_id)
    {
        return  ThTipoPlantilla::with('pilares', 'pilares.competencias')->where('id', $plantilla_id)
        ->get();
    }

    public function finalizarEvaluacion(int $id, $request)
    {
        $evaluacion = EvaluacionesDesempeno::find($id);
        return $evaluacion->update([
            'resultado' => $request->suma,
            'esta_activo' => 0
        ]);
    }
}
