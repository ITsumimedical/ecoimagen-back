<?php

namespace App\Http\Modules\SaludOcupacional\Repositories;

use App\Http\Modules\Bases\RepositoryBase;
use App\Http\Modules\SaludOcupacional\Models\SaludOcupacional;

class HistoriaOcupacionalRepository extends RepositoryBase
{

    public function __construct(protected SaludOcupacional $saludOcupacionalModel) {
        parent::__construct($this->saludOcupacionalModel);
    }

    public function guardarHistoriaOcupacional($request){
        return $this->saludOcupacionalModel::updateOrCreate(
            ['consulta_id' => $request->consulta_id],
            [
                'consulta_id' => $request->consulta_id,
                'tipo_examen' => $request->tipo_examen,
                'tipo_consulta' => $request->tipo_consulta,
                'enfermedad_actual' => $request->enfermedad_actual,
            ]
        ); 
    }

    public function consultarMotivoOcupacional($consulta_id) {
        return $this->saludOcupacionalModel::where('consulta_id', $consulta_id)->get(['enfermedad_actual']);
    }

}
