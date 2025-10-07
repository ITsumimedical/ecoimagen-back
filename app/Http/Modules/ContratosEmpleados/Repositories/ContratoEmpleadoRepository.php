<?php

namespace App\Http\Modules\ContratosEmpleados\Repositories;

use App\Http\Modules\Bases\RepositoryBase;
use App\Http\Modules\ContratosEmpleados\Models\ContratoEmpleado;

class ContratoEmpleadoRepository extends RepositoryBase {

    protected $contratoEmpleadoModel;

    public function __construct(){
       $contratoEmpleadoModel = new ContratoEmpleado();
       parent::__construct($contratoEmpleadoModel);
       $this->contratoEmpleadoModel = $contratoEmpleadoModel;
    }

    public function listarContratoEmpleado($data, $id)
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

    public function terminar($id){
        return $this->contratoEmpleadoModel->where('contrato_empleados.id',$id)->update([
            'activo' => false
        ]);
    }

    public function contratosPorFechaIngreso($request){
        $contratos = ContratoEmpleado::select('contrato_empleados.id as contrato_id', 'contrato_empleados.activo', 'contrato_empleados.empleado_id')
        ->where('fecha_ingreso', '<=', $request["fecha_cierre_mes"])
        ->get();

        return $contratos;
    }
}
