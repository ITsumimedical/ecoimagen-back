<?php

namespace App\Http\Modules\VacacionesEmpleados\Repositories;

use App\Http\Modules\Bases\RepositoryBase;
use App\Http\Modules\VacacionesEmpleados\Models\VacacionEmpleado;

class VacacionEmpleadoRepository extends RepositoryBase {

    protected $vacacionEmpleadoModel;

    public function __construct(){
        $vacacionEmpleadoModel = new VacacionEmpleado();
        parent::__construct($vacacionEmpleadoModel);
        $this->vacacionEmpleadoModel = $vacacionEmpleadoModel;
     }

     /**
      * listarVacacionContrato - lista la vacación según el id de su contrato
      *
      * @param  mixed $data
      * @param  mixed $id
      * @return void
      */
     public function listarVacacionContrato($data, $id)
     {
         /** Definimos el orden*/
         $orden = isset($data->orden) ? $data->orden : 'desc';
         if($data->page){
             $filas = $data->filas ? $data->filas : 10;
             return $this->model
                 ->orderBy('created_at', $orden)
                 ->paginate($filas)
                 ->where('contrato_id', $id);
         }else{
             return $this->model
                 ->orderBy('created_at', $orden)
                 ->where('contrato_id', $id)
                 ->get();
         }
     }

}
