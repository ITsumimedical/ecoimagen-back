<?php

namespace App\Http\Modules\HijosEmpleados\Repositories;

use App\Http\Modules\Bases\RepositoryBase;
use App\Http\Modules\HijosEmpleados\Models\HijoEmpleado;

class HijoEmpleadoRepository extends RepositoryBase {

    protected $hijoEmpleadoModel;

    public function __construct(){
        $hijoEmpleadoModel = new HijoEmpleado();
        parent::__construct($hijoEmpleadoModel);
        $this->hijoEmpleadoModel = $hijoEmpleadoModel;
     }

     public function listarHijoEmpleado($data, $id)
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
