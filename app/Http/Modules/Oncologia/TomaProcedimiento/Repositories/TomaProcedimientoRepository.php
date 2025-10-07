<?php

namespace app\Http\Modules\Oncologia\TomaProcedimiento\Repositories;

use App\Http\Modules\Afiliados\Models\Afiliado;
use App\Http\Modules\Bases\RepositoryBase;
use App\Http\Modules\Consultas\Models\Consulta;
use App\Http\Modules\Consultas\Repositories\ConsultaRepository;
use App\Http\Modules\Oncologia\TomaProcedimiento\Models\TomaProcedimiento;

class TomaProcedimientoRepository extends RepositoryBase {


    public function __construct(protected TomaProcedimiento $TomaProcedimientoModel, protected ConsultaRepository $consultaRepository) {
        parent::__construct($this->TomaProcedimientoModel);
    }

    public function listarTomaProcedimientosPendientes(){
        return $this->TomaProcedimientoModel->select(
            'toma_procedimientos.id',
            'afiliados.numero_documento',
            'reps.nombre as reps',
            'toma_procedimientos.tipo_radicacion',
            'estados.nombre as estado',
            'cie10s.codigo_cie10',
            'cie10s.nombre as cie10',
            'consultas.id as consulta_id',
            'adjuntos_oncologicos.nombre as adjunto',
            'adjuntos_oncologicos.ruta',
            'toma_procedimientos.created_at as fecha_registro',
            'toma_procedimientos.seguimiento',
            'toma_procedimientos.clasificacion_muestra')
        ->join('afiliados', 'toma_procedimientos.afiliado_id', 'afiliados.id')
        ->join('reps', 'toma_procedimientos.rep_id', 'reps.id')
        ->join('estados', 'toma_procedimientos.estado_id', 'estados.id')
        ->leftjoin('cie10s', 'toma_procedimientos.cie10_id', 'cie10s.id')
        ->leftjoin('consultas', 'toma_procedimientos.consulta_id', 'consultas.id')
        ->join('operadores', 'toma_procedimientos.registrado_por_id', 'operadores.user_id')
        ->join('adjuntos_oncologicos', 'toma_procedimientos.id', 'adjuntos_oncologicos.toma_procedimiento_id')
        ->selectRaw("CONCAT(operadores.nombre,' ',operadores.apellido) as empleado")
        ->selectRaw("CONCAT(afiliados.primer_nombre,' ',afiliados.primer_apellido,' ',afiliados.segundo_nombre,' ',afiliados.segundo_apellido) as afiliado")
        ->where('toma_procedimientos.estado_id', 10)
        ->where('toma_procedimientos.tipo_radicacion', 'CARGA DE RESULTADOS')
        ->get();
    }


    public function contadorPendientes() {
        return $this->TomaProcedimientoModel->where('estado_id', 10)->where('toma_procedimientos.tipo_radicacion', 'CARGA DE RESULTADOS')->count();
    }

    public function contadorPendienteOrdenamiento() {
        return $this->TomaProcedimientoModel->where('estado_id', 22)->count();
    }

    public function contadorSeguimiento() {
        return $this->TomaProcedimientoModel->where('estado_id', 9)->count();
    }

    public function contadorTomaMuestra()
    {
       return $this->TomaProcedimientoModel->where('toma_procedimientos.tipo_radicacion','TOMA DE MUESTRA')->count();
    }

    public function crear($data){
        return $this->TomaProcedimientoModel->create($data);
    }


    public function listarTomaProcedimientosPendientesCita(){
        return Consulta::select('consultas.*',
            'toma_procedimientos.id as toma',
            'afiliados.numero_documento',
            'reps.nombre as reps',
            'toma_procedimientos.tipo_radicacion',
            'estados.nombre as estadoR',
            'cie10s.codigo_cie10',
            'cie10s.nombre as cie10',
            'adjuntos_oncologicos.nombre as adjunto',
            'adjuntos_oncologicos.ruta',
            'toma_procedimientos.created_at as fecha_registro',
            'toma_procedimientos.clasificacion_muestra',
            'toma_procedimientos.seguimiento')
        ->join('toma_procedimientos','toma_procedimientos.consulta_id','consultas.id')
        ->with(['ordenes' => function ($query) {
            $query->select(['ordenes.*','orden_procedimientos.id as consecutivo',
            'orden_procedimientos.created_at as FechaOrdenamiento','orden_procedimientos.fecha_vigencia',
            'orden_procedimientos.cantidad as Cantidad_Dosis','cups.nombre as Nombre',
            'cups.codigo as Codigo','estados.id as estadoOrden','estados.nombre as nombreEstado',
            'cups.requiere_auditoria as Requiere_Autorizacion',
            'auditorias.created_at as fechaAutorizacion',
            'auditorias.observaciones as observacionAutorizacion'])
                ->join('orden_procedimientos', 'orden_procedimientos.orden_id', 'ordenes.id')
                ->join('cups', 'orden_procedimientos.cup_id', 'cups.id')
                ->leftjoin('auditorias', 'auditorias.orden_procedimiento_id', 'orden_procedimientos.id')
                ->join('estados','estados.id','orden_procedimientos.estado_id')
//                ->where('orden_procedimientos.estado_id', 4)
                ->distinct()
                ->get();
         }])
            ->with(['OrdenesCodigosPropios' => function ($query) {
                $query->select(['ordenes.*'
                    ,'orden_codigo_propios.id as consecutivo',
                    'orden_codigo_propios.created_at as FechaOrdenamiento','orden_codigo_propios.fecha_vigencia',
                    'orden_codigo_propios.cantidad as Cantidad_Dosis','codigo_propios.nombre as Nombre',
                    'codigo_propios.codigo as Codigo','estados.id as estadoOrden','estados.nombre as nombreEstado',
                    'codigo_propios.requiere_auditoria as Requiere_Autorizacion',
                    'auditorias.created_at as fechaAutorizacion',
                    'auditorias.observaciones as observacionAutorizacion'
                ])
                    ->join('orden_codigo_propios', 'orden_codigo_propios.orden_id', 'ordenes.id')
                    ->join('codigo_propios', 'orden_codigo_propios.codigo_propio_id', 'codigo_propios.id')
                    ->leftjoin('auditorias', 'auditorias.orden_codigo_propio_id', 'orden_codigo_propios.id')
                    ->join('estados','estados.id','orden_codigo_propios.estado_id')
                    ->distinct()
                    ->get();
            }])
        // ->join('ordenes','ordenes.consulta_id','consultas.id')
        ->join('afiliados', 'toma_procedimientos.afiliado_id', 'afiliados.id')
        ->join('reps', 'toma_procedimientos.rep_id', 'reps.id')
        ->join('estados', 'toma_procedimientos.estado_id', 'estados.id')
        ->leftjoin('cie10s', 'toma_procedimientos.cie10_id', 'cie10s.id')
        ->join('operadores', 'toma_procedimientos.registrado_por_id', 'operadores.user_id')
        ->join('adjuntos_oncologicos', 'toma_procedimientos.id', 'adjuntos_oncologicos.toma_procedimiento_id')
            ->selectRaw("CONCAT(operadores.nombre,' ',operadores.apellido) as empleado")
        ->selectRaw("CONCAT(afiliados.primer_nombre,' ',afiliados.primer_apellido,' ',afiliados.segundo_nombre,' ',afiliados.segundo_apellido) as afiliado")

        ->where('toma_procedimientos.estado_id', 22)
        ->where('toma_procedimientos.tipo_radicacion', 'CARGA DE RESULTADOS')
        ->get();
    }

    public function actualizarEstado($toma){
        $tomaProcedimiento = $this->TomaProcedimientoModel::find($toma);
        return $tomaProcedimiento->update([
            'estado_id' => 22
          ]);
    }

    public function listarTomaMuestrasRealizadas()
    {
        return TomaProcedimiento::with('organo','afiliado','rep','registrado','adjunto')
            ->where('toma_procedimientos.tipo_radicacion','TOMA DE MUESTRA')
            ->get();
    }
}
