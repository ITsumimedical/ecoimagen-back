<?php

namespace App\Http\Modules\Solicitudes\TipoSolicitudEmpleado\Repositories;

use App\Http\Modules\Bases\RepositoryBase;
use App\Http\Modules\Solicitudes\TipoSolicitudEmpleado\Models\TipoSolicitudEmpleado;

class TipoSolicitudEmpleadoRepository extends RepositoryBase{

    public function __construct(protected TipoSolicitudEmpleado $tipoSolicitudEmpleadoModel){
        parent::__construct($this->tipoSolicitudEmpleadoModel);
    }

    public function listarTipo($request){
      $tipo=  $this->tipoSolicitudEmpleadoModel->select('empleados.id','empleados.documento','tipo_solicitud_empleados.tipo_solicitud_red_vital_id as idTipo')
      ->selectRaw("CONCAT(empleados.primer_nombre, ' ',empleados.primer_apellido) as nombre ")
        ->join('empleados','tipo_solicitud_empleados.empleado_id','empleados.id')
        ->where('tipo_solicitud_empleados.tipo_solicitud_red_vital_id',$request['id'])
        ->where('tipo_solicitud_empleados.activo',1);

        return $request['page'] ? $tipo->paginate($request['cantidad']) : $tipo->get();
    }

    public function crearoActualizar($empleado,$tipoSolicitud){
        $this->tipoSolicitudEmpleadoModel->updateOrCreate(['empleado_id' =>  $empleado,'tipo_solicitud_red_vital_id'=> $tipoSolicitud],
        [
        'empleado_id' =>  $empleado,
        'tipo_solicitud_red_vital_id'=> $tipoSolicitud,
         'activo' => true
    ]);
    }

    public function inactivarEmpleado($request){
        $this->tipoSolicitudEmpleadoModel->where('tipo_solicitud_red_vital_id',$request['tipoSolicitud_id'])
        ->where('empleado_id',$request['id_empleado'])
        ->update(['activo'=>false]);
    }

    public function obtenerTipo($id_tipo){
        return $this->tipoSolicitudEmpleadoModel->select('users.id')
        ->join('empleados','tipo_solicitud_empleados.empleado_id','empleados.id')
        ->join('users','empleados.user_id','users.id')
        ->where('tipo_solicitud_red_vital_id',$id_tipo)
        ->where('activo',1)->get();
    }
}
