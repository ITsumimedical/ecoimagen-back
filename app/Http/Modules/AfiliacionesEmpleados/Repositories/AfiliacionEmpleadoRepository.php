<?php

namespace App\Http\Modules\AfiliacionesEmpleados\Repositories;

use App\Http\Modules\AfiliacionesEmpleados\Models\AfiliacionEmpleado;
use App\Http\Modules\Bases\RepositoryBase;

class AfiliacionEmpleadoRepository extends RepositoryBase {

    protected $afiliacionEmpleadoModel;

    public function __construct(){
        $afiliacionEmpleadoModel = new AfiliacionEmpleado();
        parent::__construct($afiliacionEmpleadoModel);
        $this->afiliacionEmpleadoModel = $afiliacionEmpleadoModel;
     }

    //  public function listarAfiliacionEmpleado($data, $id)
    //  {
    //      /** Definimos el orden*/
    //      $orden = isset($data->orden) ? $data->orden : 'desc';
    //      if($data->page){
    //          $filas = $data->filas ? $data->filas : 10;
    //          return $this->model
    //              ->orderBy('created_at', $orden)
    //              ->paginate($filas)
    //              ->where('contrato_id', $id);
    //      }else{
    //          return $this->model
    //              ->orderBy('created_at', $orden)
    //              ->where('contrato_id', $id)
    //              ->get();
    //      }
    //  }

     public function listarAfiliacionEmpleado($data,$id){
        $afiliaciones = AfiliacionEmpleado::select('afiliacion_empleados.id', 'afiliacion_empleados.fecha_afiliacion',
        'afiliacion_empleados.fecha_fin_afiliacion', 'afiliacion_empleados.prestador_id', 'afiliacion_empleados.contrato_id',
        'afiliacion_empleados.estado', 'tipo_prestador_ths.nombre as tipoPrestador', 'prestador_ths.nombre as prestador',
        'prestador_ths.nit')
        ->leftjoin('prestador_ths', 'prestador_ths.id', 'afiliacion_empleados.prestador_id')
        ->leftjoin('tipo_prestador_ths', 'tipo_prestador_ths.id', 'afiliacion_empleados.prestador_id',)
        ->where('contrato_id', $id)
        ->get();
        return $afiliaciones;
     }

}
