<?php

namespace App\Http\Modules\IncapacidadesEmpleados\Repositories;

use App\Http\Modules\Bases\RepositoryBase;
use App\Http\Modules\IncapacidadesEmpleados\Models\IncapacidadEmpleado;

class IncapacidadEmpleadoRepository extends RepositoryBase {

    protected $incapacidadEmpleadoModel;

    public function __construct(){
        $incapacidadEmpleadoModel = new IncapacidadEmpleado();
        parent::__construct($incapacidadEmpleadoModel);
        $this->incapacidadEmpleadoModel = $incapacidadEmpleadoModel;
     }

     public function listarIncapacidadContrato($data, $id)
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

     public function listarIncapacidadInicial($data, $id)
     {

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
                 ->where('clase', 'Inicial')
                 ->get();
         }
     }

}
