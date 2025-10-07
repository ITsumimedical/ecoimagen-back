<?php

namespace App\Http\Modules\EvaluacionDesempeño\Calificacion_Competencia\Repositories;

use App\Http\Modules\Bases\RepositoryBase;
use App\Http\Modules\EvaluacionDesempeño\Calificacion_Competencia\Models\CalificacionCompetencia;

class CalificacionCompetenciaRepository extends RepositoryBase {

    protected $CalificacionCompetenciaModel;

    public function __construct(CalificacionCompetencia $CalificacionCompetenciaModel) {
        parent::__construct($CalificacionCompetenciaModel);
        $this->CalificacionCompetenciaModel = $CalificacionCompetenciaModel;
    }

    public function firstOrCreateCalificacionDesempeno()
    {
        $calificacion = CalificacionCompetencia::updateOrCreate([
            'evaluaciones_desempeno_id' =>  request('evaluaciones_desempeno_id'),
            'th_competencia_id' =>  request('th_competencia_id')],
            ['calificacion' =>  request('calificacion')]
        );
        return $calificacion;
    }

    public function consultarCalificaciones($request)
    {
        return CalificacionCompetencia::where('evaluaciones_desempeno_id', $request->evaluaciones_desempeno_id)->get();
    }

}
