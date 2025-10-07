<?php

namespace App\Http\Modules\EvaluacionDesempeño\Th_Configuracion\Repositories;

use App\Http\Modules\Bases\RepositoryBase;
use App\Http\Modules\EvaluacionDesempeño\Th_Configuracion\Models\Configuracion;
use Psy\CodeCleaner\ReturnTypePass;

class ThConfiguracionRepository extends RepositoryBase {

    protected $ThConfiguracionModel;

    /**
     * __construct configuracion
     *
     * @param  mixed $ThConfiguracionModel
     * @return void
     * @author Calvarez
     */
    public function __construct(Configuracion $ThConfiguracionModel) {
        parent::__construct($ThConfiguracionModel);
        $this->ThConfiguracionModel = $ThConfiguracionModel;
    }

    public function crearConfiguracion($newThConfiguracion)
    {
        return Configuracion::create([
            'fecha_inicio_evaluacion_desempeno' => $newThConfiguracion->fecha_inicio_evaluacion_desempeno,
            'fecha_final_evaluacion_desempeno' => $newThConfiguracion->fecha_final_evaluacion_desempeno,
            'generado_por' => auth()->id(),
        ]);
    }

    public function ultimaFechaEvaluacion()
    {
        return Configuracion::latest()->first();
    }


}
