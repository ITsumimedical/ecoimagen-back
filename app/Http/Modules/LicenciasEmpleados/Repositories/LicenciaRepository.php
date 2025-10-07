<?php

namespace App\Http\Modules\LicenciasEmpleados\Repositories;

use App\Http\Modules\Bases\RepositoryBase;
use App\Http\Modules\LicenciasEmpleados\Models\LicenciaEmpleado;

class LicenciaRepository extends RepositoryBase {

    protected $licenciaEmpleadoModel;

    public function __construct(){
        $licenciaEmpleadoModel = new LicenciaEmpleado();
        parent::__construct($licenciaEmpleadoModel);
        $this->licenciaEmpleadoModel = $licenciaEmpleadoModel;
    }

    public function listarLicenciaEmpleado($data, $id)
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

    public function listarConTipo($data, $id){
        $licencias = LicenciaEmpleado::select(
            'licencia_empleados.id', 'licencia_empleados.tipo_licencia_id', 'licencia_empleados.contrato_id', 'licencia_empleados.estado_id',
            'licencia_empleados.fecha_inicio', 'licencia_empleados.fecha_fin', 'licencia_empleados.observaciones', 'licencia_empleados.motivo',
            'tipo_licencia_empleados.nombre as nombreTipoLicencia'
        )       ->join('tipo_licencia_empleados', 'tipo_licencia_empleados.id', 'licencia_empleados.tipo_licencia_id')
                ->where('contrato_id', $id)
                ->get();

        return $licencias;
    }
}
