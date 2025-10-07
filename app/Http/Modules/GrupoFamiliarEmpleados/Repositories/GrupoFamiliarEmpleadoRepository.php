<?php

namespace App\Http\Modules\GrupoFamiliarEmpleados\Repositories;

use App\Http\Modules\Bases\RepositoryBase;
use App\Http\Modules\GrupoFamiliarEmpleados\Models\GrupoFamiliarEmpleado;

class GrupoFamiliarEmpleadoRepository extends RepositoryBase {

    protected $grupoFamiliarEmpleadoModel;

    public function __construct(){
        $grupoFamiliarEmpleadoModel = new GrupoFamiliarEmpleado();
        parent::__construct($grupoFamiliarEmpleadoModel);
        $this->grupoFamiliarEmpleadoModel = $grupoFamiliarEmpleadoModel;
     }

     public function listarGrupoFamiliarEmpleado($data, $id)
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
