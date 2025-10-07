<?php

namespace App\Http\Modules\HistoricoContratoEmpleado\Repositories;

use Illuminate\Support\Facades\DB;
use App\Http\Modules\Bases\RepositoryBase;
use App\Http\Modules\HistoricoContratoEmpleado\Models\HistoricoContratoEmpleado;

class HistoricoContratoEmpleadoRepository extends RepositoryBase {

    protected $historicoModel;

    public function __construct() {
        $this->historicoModel = new HistoricoContratoEmpleado();
        parent::__construct($this->historicoModel);
    }

    public function listarHistoricoContrato($id)
    {
       $historicos = HistoricoContratoEmpleado::select('historico_contrato_empleados.id', 'historico_contrato_empleados.contrato_empleado_id', 'historico_contrato_empleados.user_id',
       'historico_contrato_empleados.cargo_id', 'historico_contrato_empleados.proyecto_id', 'historico_contrato_empleados.tipo_contrato_id', 'historico_contrato_empleados.salario',
       'historico_contrato_empleados.horas','historico_contrato_empleados.fecha_ingreso', 'historico_contrato_empleados.fecha_vencimiento', 'historico_contrato_empleados.fecha_retiro',
       'historico_contrato_empleados.fecha_fin_periodo_prueba', 'historico_contrato_empleados.fecha_aplicacion_novedad', 'historico_contrato_empleados.jornada', 'historico_contrato_empleados.activo',
       'historico_contrato_empleados.tipo_terminacion', 'historico_contrato_empleados.motivo_terminacion', 'historico_contrato_empleados.justa_causa', 'historico_contrato_empleados.numero_cuenta_bancaria',
       'historico_contrato_empleados.municipio_trabaja_id', 'historico_contrato_empleados.tipo_cuenta_id', 'historico_contrato_empleados.banco_id', 'historico_contrato_empleados.accion',
       'historico_contrato_empleados.observaciones',
    //     'cargos.nombre as nombre_cargo','proyectos.nombre as nombre_proyecto', 'tipo_contrato_ths.nombre as nombre_tipo_contrato',
    //    'municipios.nombre as nombre_municipio_trabaja', 'tipo_cuenta_bancarias.nombre as nombre_tipo_cuenta',
    //    DB::raw("FORMAT(historico_contrato_empleados.created_at,'yyyy-MM-dd hh:mm:ss ') as fecha_creacion"),
       )
    //    ->join('users','historico_contrato_empleados.user_id','users.id')
    //    ->join('empleados','users.id','empleados.user_id')
    //    ->leftjoin('contrato_empleados', 'historico_contrato_empleados.id', 'contrato_empleados.empleado_id')
    //    ->leftjoin('cargos', 'historico_contrato_empleados.cargo_id', 'cargos.id')
    //    ->leftjoin('proyectos', 'historico_contrato_empleados.proyecto_id', 'proyectos.id')
    //    ->leftjoin('tipo_contrato_ths', 'historico_contrato_empleados.tipo_contrato_id', 'tipo_contrato_ths.id')
    //    ->leftjoin('municipios', 'historico_contrato_empleados.municipio_trabaja_id', 'municipios.id')
    //    ->leftjoin('tipo_cuenta_bancarias', 'historico_contrato_empleados.tipo_cuenta_id', 'tipo_cuenta_bancarias.id')
    //    ->selectRaw("CONCAT(primer_nombre,' ',segundo_nombre,' ',primer_apellido,' ',segundo_apellido) as empleado_registra")
       ->where('contrato_empleado_id', $id)
       ->orderBy('historico_contrato_empleados.created_at','desc')
       ->get();

       return $historicos;
    }
}
