<?php

namespace App\Http\Modules\MascotasEmpleados\Repositories;

use App\Http\Modules\Bases\RepositoryBase;
use App\Http\Modules\MascotasEmpleados\Models\MascotaEmpleado;

class MascotaEmpleadoRepository extends RepositoryBase {
    
    protected $mascotaEmpleadoModel;

    public function __construct(){
        $mascotaEmpleadoModel = new MascotaEmpleado();
        parent::__construct($mascotaEmpleadoModel);
        $this->mascotaEmpleadoModel = $mascotaEmpleadoModel;
     }

     public function listarMascotaEmpleado($data, $id)
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
