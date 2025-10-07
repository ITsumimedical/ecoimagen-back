<?php

namespace App\Http\Modules\Indicadores\Repositories;

use App\Http\Modules\Bases\RepositoryBase;
use App\Http\Modules\Indicadores\Models\DatosIndicadorFomagOncologico;
use App\Http\Modules\InformacionCuidador\Models\InformacionCuidador;

class IndicadorRepository extends RepositoryBase
{
    public function __construct(protected DatosIndicadorFomagOncologico $datosIndicadorFomagOncologico )
    {
    }

    public function historicoDatos($request){
        $datos = $this->datosIndicadorFomagOncologico->orderBy('id','desc');
        if($request['clasificacion_ca_priorizado']){
            $datos->where('clasificacion_ca_priorizado',$request['clasificacion_ca_priorizado']);
        }
        if($request['documento']){
            $datos->where('documento',$request['documento']);
        }
        return $datos->get();
    }
}
