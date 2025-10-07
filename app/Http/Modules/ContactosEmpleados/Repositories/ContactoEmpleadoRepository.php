<?php

namespace App\Http\Modules\ContactosEmpleados\Repositories;

use App\Http\Modules\Bases\RepositoryBase;
use App\Http\Modules\ContactosEmpleados\Models\ContactoEmpleado;

class ContactoEmpleadoRepository extends RepositoryBase {

    protected $contactoEmpleadoModel;

    public function __construct(){
        $contactoEmpleadoModel = new ContactoEmpleado();
        parent::__construct($contactoEmpleadoModel);
        $this->contactoEmpleadoModel = $contactoEmpleadoModel;
     }

     public function listarContactoEmpleado($data, $id)
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
