<?php

namespace App\Http\Modules\InduccionesEspecificas\TemasInduccionesEspecificas\Repositories;

use App\Http\Modules\Bases\RepositoryBase;
use App\Http\Modules\InduccionesEspecificas\TemasInduccionesEspecificas\Models\TemaInduccionEspecifica;

class TemaInduccionEspecificaRepository extends RepositoryBase {

    protected $temaModel;

    public function __construct() {
        $this->temaModel = new TemaInduccionEspecifica();
        parent::__construct($this->temaModel);
    }

    public function listarConPlantilla(){
        $temas = TemaInduccionEspecifica::select(
            'tema_induccion_especificas.id', 'tema_induccion_especificas.nombre', 'tema_induccion_especificas.plantilla_id',
            'plantilla_induccion_especificas.nombre as nombrePlantilla'
        )
        ->join('plantilla_induccion_especificas', 'plantilla_induccion_especificas.id', 'plantilla_id')
        ->get();

        return $temas;
    }

    public function listarTemaDePlantilla($data, $id)
    {
        /** Definimos el orden*/
        $orden = isset($data->orden) ? $data->orden : 'asc';
        if($data->page){
            $filas = $data->filas ? $data->filas : 10;
            return $this->model
                ->orderBy('created_at', $orden)
                ->paginate($filas)
                ->where('plantilla_id', $id);
        }else{
            return $this->model
                ->orderBy('created_at', $orden)
                ->where('plantilla_id', $id)
                ->get();
        }
    }
}
