<?php

namespace App\Http\Modules\EstudiosEmpleados\Repositories;

use App\Http\Modules\Bases\RepositoryBase;
use App\Http\Modules\EstudiosEmpleados\Models\EstudioEmpleado;

class EstudioEmpleadoRepository extends RepositoryBase {

    protected $estudioEmpleadoModel;

    public function __construct(){
       $estudioEmpleadoModel = new EstudioEmpleado();
       parent::__construct($estudioEmpleadoModel);
       $this->estudioEmpleadoModel = $estudioEmpleadoModel;
    }

    public function listarEstudioEmpleado($data, $id)
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
                ->get();
        }
    }
}
