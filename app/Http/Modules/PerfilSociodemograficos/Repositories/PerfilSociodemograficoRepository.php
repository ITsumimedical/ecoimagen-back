<?php

namespace App\Http\Modules\PerfilSociodemograficos\Repositories;

use App\Http\Modules\Bases\RepositoryBase;
use App\Http\Modules\PerfilSociodemograficos\Models\PerfilSociodemografico;

class PerfilSociodemograficoRepository extends RepositoryBase {

    protected $perfilModelo;

    public function __construct() {
        $this->perfilModelo = new PerfilSociodemografico();
        parent::__construct($this->perfilModelo);
    }

    public function listarPerfilEmpleado($data, $id)
    {
        /** Definimos el orden*/
        $orden = isset($data->orden) ? $data->orden : 'desc';
        if($data->page){
            $filas = $data->filas ? $data->filas : 10;
            return $this->model
                ->orderBy('created_at', $orden)
                ->paginate($filas)
                ->where('empleado_id', $id);
        }else{
            return $this->model
                ->orderBy('created_at', $orden)
                ->where('empleado_id', $id)
                ->first();
        }
    }
}
