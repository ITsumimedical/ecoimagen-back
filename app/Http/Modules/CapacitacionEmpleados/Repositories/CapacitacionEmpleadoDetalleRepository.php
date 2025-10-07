<?php

namespace App\Http\Modules\CapacitacionEmpleados\Repositories;

use App\Http\Modules\Bases\RepositoryBase;
use App\Http\Modules\CapacitacionEmpleados\Models\CapacitacionEmpleadoDetalle;

class CapacitacionEmpleadoDetalleRepository extends RepositoryBase {

    protected $capacitacionEmpleadoDetalleModel;

    public function __construct(){
       $capacitacionEmpleadoDetalleModel = new CapacitacionEmpleadoDetalle();
       parent::__construct($capacitacionEmpleadoDetalleModel);
       $this->capacitacionEmpleadoDetalleModel = $capacitacionEmpleadoDetalleModel;
    }

    public function listarCapacitacionDetalle($data, $id)
    {
        /** Definimos el orden*/
        $orden = isset($data->orden) ? $data->orden : 'desc';
        if($data->page){
            $filas = $data->filas ? $data->filas : 10;
            return $this->model
                ->orderBy('created_at', $orden)
                ->paginate($filas)
                ->where('capacitacion_id', $id);
        }else{
            return $this->model
                ->orderBy('created_at', $orden)
                ->where('capacitacion_id', $id)
                ->get();
        }
    }
}
