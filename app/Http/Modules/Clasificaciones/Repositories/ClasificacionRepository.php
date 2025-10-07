<?php

namespace App\Http\Modules\Clasificaciones\Repositories;

use App\Http\Modules\Bases\RepositoryBase;
use App\Http\Modules\Clasificaciones\Models\clasificacion;

class ClasificacionRepository extends RepositoryBase {

    protected $modelo;

    public function __construct() {
        $this->modelo = new clasificacion();
        parent::__construct($this->modelo);
    }

    public function listar($data){
            /** Definimos el orden*/
            $orden = isset($data->orden) ? $data->orden : 'desc';
            $filas = $data->filas ? $data->filas : 10;
    
            $consulta = $this->modelo
                ->orderBy('created_at', $orden)
                ->whereEstado($data->estado);
            
            return $data->page ? $consulta->paginate($filas) : $consulta->get();
    }

}
