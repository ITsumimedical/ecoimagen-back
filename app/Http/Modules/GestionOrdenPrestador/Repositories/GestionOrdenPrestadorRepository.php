<?php

namespace App\Http\Modules\GestionOrdenPrestador\Repositories;

use App\Http\Modules\Bases\RepositoryBase;
use App\Http\Modules\Consultas\Models\Consulta;
use App\Http\Modules\Consultas\Models\ConsultaOrdenProcedimientos;
use App\Http\Modules\Consultas\Services\ConsultaService;
use App\Http\Modules\GestionOrdenPrestador\Models\GestionOrdenPrestador;
use App\Http\Modules\Ordenamiento\Models\OrdenCodigoPropio;
use App\Http\Modules\Ordenamiento\Models\OrdenProcedimiento;
use App\Http\Modules\Reps\Models\ParametrizacionCupPrestador;
use App\Traits\ArchivosTrait;
use Illuminate\Support\Facades\DB;

class GestionOrdenPrestadorRepository extends RepositoryBase
{
    protected $model;

    use ArchivosTrait;

    public function __construct(protected AdjuntoGestionOrdenRepository $AdjuntoGestionOrdenRepository,protected ConsultaService $consultaService)
    {
        $this->model = new GestionOrdenPrestador();
        parent::__construct($this->model);
    }
    public function enviarDetalle($request)
    {
        $estado = $request['estado'];

        switch (intval($estado)) {
            case 51:
                foreach($request['id'] as $ordenProcedimientoId){
                    $nuevaGestion = new GestionOrdenPrestador();
    
                    if ($request['tipoOrden'] == 'servicio') {
                        $nuevaGestion['orden_procedimiento_id'] = $ordenProcedimientoId;
    
                        $ordenProcedimiento = OrdenProcedimiento::find($ordenProcedimientoId);
                        $ordenProcedimiento['estado_id_gestion_prestador'] = $estado;
                        $ordenProcedimiento['estado_id'] = 1;
                        $ordenProcedimiento['fecha_ejecucion'] = $request['fecha_asistencia'];
                        
                        $ordenProcedimiento->save();
                    } else {
                        
                        $nuevaGestion['orden_codigo_propio_id'] = $ordenProcedimientoId;
    
                        $ordenCodigoPropio = OrdenCodigoPropio::find($ordenProcedimientoId);
                        $ordenCodigoPropio['estado_id_gestion_prestador'] = $estado;
                        $ordenCodigoPropio['estado_id'] = 1;
                        $ordenCodigoPropio['fecha_ejecucion'] = $request['fecha_asistencia'];
                        $ordenCodigoPropio->save();
                    }
    
                    $nuevaGestion['estado_gestion_id'] = $request['estado'];
                    // $nuevaGestion['fecha_sugerida'] = $request['fecha_sugerida'];
                    // $nuevaGestion['fecha_solicita_afiliado'] = $request['fecha_solicitada_afiliado'];
                    $nuevaGestion['fecha_resultado'] = $request['fecha_resultado'];
                    $nuevaGestion['observacion'] = $request['observaciones'];
                    $nuevaGestion['funcionario_responsable'] = $request['funcionario_responsable'];
                    $nuevaGestion['funcionario_gestiona'] = auth()->user()->id;
                    $nuevaGestion['cirujano'] = $request['cirujano'];
                    $nuevaGestion['especialidad'] = $request['especialidad'];
                    $nuevaGestion['fecha_preanestesia'] = $request['fecha_preanestesia'];
                    $nuevaGestion['fecha_cirugia'] = $request['fecha_cirugia'];
                    $nuevaGestion['fecha_ejecucion'] = $request['fecha_ejecucion'];
                    $nuevaGestion['fecha_asistencia'] = $request['fecha_asistencia'];
                    $nuevaGestion->save();
                    if (isset($request['adjuntos'])) {
                        $archivos = $request['adjuntos'];
                        $ruta = 'adjuntosGestionOrden/'.$ordenProcedimientoId.'/asistencia';
    
                        foreach ($archivos as $archivo) {
                            $nombre = $archivo->getClientOriginalName();
                            $subirArchivo = $this->subirArchivoNombre($ruta, $archivo, $nombre, 'server37');
                            $adjunto = $this->AdjuntoGestionOrdenRepository->crear([
                                'nombre' => $nombre,
                                'ruta' => $subirArchivo,
                                'gestion_orden_id' => $nuevaGestion->id
                            ]);
                        }
                    }
                
                
                }
                break;
            case 30:
                foreach($request['id'] as $ordenProcedimientoId){
                    $nuevaGestion = new GestionOrdenPrestador();
    
                    if ($request['tipoOrden'] == 'servicio') {
                        $nuevaGestion['orden_procedimiento_id'] = $ordenProcedimientoId;   
                        $ordenProcedimiento = OrdenProcedimiento::find($ordenProcedimientoId);
                        $ordenProcedimiento['estado_id_gestion_prestador'] = $estado;
                        $ordenProcedimiento->save();
                        $ordenConsulta = ConsultaOrdenProcedimientos::where('orden_procedimiento_id',$ordenProcedimientoId)->first();
                        if($ordenConsulta){
                            $consulta = Consulta::find($ordenConsulta->consulta_id);
                            $datos = [
                                'consulta' => $consulta->id,
                                'afiliado' => $consulta->afiliado_id,
                                'motivoCancelacion' => ($request['motivo_cancelacion']?:$request['causa_cancelacion'])
                            ];
                            $this->consultaService->cancelar($datos);
                        }
                    } else {
                        $nuevaGestion['orden_codigo_propio_id'] = $ordenProcedimientoId;
                        $ordenCodigoPropio = OrdenCodigoPropio::find($ordenProcedimientoId);
                        $ordenCodigoPropio['estado_id_gestion_prestador'] = $estado;
                        $ordenCodigoPropio->save();
                        $ordenConsulta = ConsultaOrdenProcedimientos::where('orden_codigo_propio_id',$ordenProcedimientoId)->first();
                        if($ordenConsulta){
                            $consulta = Consulta::find($ordenConsulta->consulta_id);
                            $datos = [
                                'consulta' => $consulta->id,
                                'afiliado' => $consulta->afiliado_id,
                                'motivoCancelacion' => ($request['motivo_cancelacion']?:$request['causa_cancelacion'])
                            ];
                            $this->consultaService->cancelar($datos);
                        }
                    }
                    $nuevaGestion['estado_gestion_id'] = $request['estado'];
                    $nuevaGestion['observacion'] = $request['observaciones'];
                    $nuevaGestion['funcionario_responsable'] = $request['funcionario_responsable'];
                    $nuevaGestion['funcionario_gestiona'] = auth()->user()->id;
                    $nuevaGestion['fecha_cancelacion'] = $request['fecha_cancelacion'];
                    $nuevaGestion['motivo_cancelacion'] = $request['motivo_cancelacion'];
                    $nuevaGestion['causa_cancelacion'] = $request['causa_cancelacion'];
                    $nuevaGestion->save();
                    if (isset($request['adjuntos'])) {
                        $archivos = $request['adjuntos'];
                        $ruta = 'adjuntosGestionOrden/'.$ordenProcedimientoId.'/cancelada';
    
                        foreach ($archivos as $archivo) {
                            $nombre = $archivo->getClientOriginalName();
                            $subirArchivo = $this->subirArchivoNombre($ruta, $archivo, $nombre, 'server37');
                            $adjunto = $this->AdjuntoGestionOrdenRepository->crear([
                                'nombre' => $nombre,
                                'ruta' => $subirArchivo,
                                'gestion_orden_id' => $nuevaGestion->id
                            ]);
                        }
                    }

                }
                break;
            case 8:
                foreach($request['id'] as $ordenProcedimientoId){
                    $nuevaGestion = new GestionOrdenPrestador();
    
                    if ($request['tipoOrden'] == 'servicio') {
                        $nuevaGestion['orden_procedimiento_id'] = $ordenProcedimientoId;
    
                        $ordenProcedimiento = OrdenProcedimiento::find($ordenProcedimientoId);
                        $ordenProcedimiento['estado_id_gestion_prestador'] = $estado;
                        $ordenProcedimiento->save();
                    } else {
                        $nuevaGestion['orden_codigo_propio_id'] = $ordenProcedimientoId;
    
                        $ordenCodigoPropio = OrdenCodigoPropio::find($ordenProcedimientoId);
                        $ordenCodigoPropio['estado_id_gestion_prestador'] = $estado;
                        $ordenCodigoPropio->save();
                    }
    
                    $nuevaGestion['estado_gestion_id'] = $request['estado'];
                    $nuevaGestion['observacion'] = $request['observaciones'];
                    $nuevaGestion['funcionario_responsable'] = $request['funcionario_responsable'];
                    $nuevaGestion['funcionario_gestiona'] = auth()->user()->id;
                    $nuevaGestion->save();

                }


                break;
            case 52:
                foreach($request['id'] as $ordenProcedimientoId){
                    $nuevaGestion = new GestionOrdenPrestador();
    
                    if ($request['tipoOrden'] == 'servicio') {
                        $nuevaGestion['orden_procedimiento_id'] = $ordenProcedimientoId;
    
                        $ordenProcedimiento = OrdenProcedimiento::find($ordenProcedimientoId);
                        $ordenProcedimiento['estado_id_gestion_prestador'] = $estado;
                        $ordenProcedimiento->save();
                    } else {
                        $nuevaGestion['orden_codigo_propio_id'] = $ordenProcedimientoId;
    
                        $ordenCodigoPropio = OrdenCodigoPropio::find($ordenProcedimientoId);
                        $ordenCodigoPropio['estado_id_gestion_prestador'] = $estado;
                        $ordenCodigoPropio->save();
                    }
    
                    $nuevaGestion['estado_gestion_id'] = $request['estado'];
                    $nuevaGestion['observacion'] = $request['observaciones'];
                    $nuevaGestion['funcionario_responsable'] = $request['funcionario_responsable'];
                    $nuevaGestion['funcionario_gestiona'] = auth()->user()->id;
                    $nuevaGestion->save();

                }
                break;
            case 58:
                
                foreach($request['id'] as $ordenProcedimientoId){
                    $nuevaGestion = new GestionOrdenPrestador();
                    if ($request['tipoOrden'] == 'servicio') {
                        $nuevaGestion['orden_procedimiento_id'] = $ordenProcedimientoId;
    
                        $ordenProcedimiento = OrdenProcedimiento::find($ordenProcedimientoId);
                        $ordenProcedimiento['estado_id_gestion_prestador'] = $estado;
                        $ordenProcedimiento->save();
                    } else {
                        $nuevaGestion['orden_codigo_propio_id'] = $ordenProcedimientoId;
    
                        $ordenCodigoPropio = OrdenCodigoPropio::find($ordenProcedimientoId);
                        $ordenCodigoPropio['estado_id_gestion_prestador'] = $estado;
                        $ordenCodigoPropio->save();
                    }
                    $nuevaGestion['estado_gestion_id'] = $request['estado'];
                    $nuevaGestion['fecha_resultado'] = $request['fecha_resultado'];
                    $nuevaGestion['observacion'] = $request['observaciones'];
                    $nuevaGestion['funcionario_responsable'] = $request['funcionario_responsable'];
                    $nuevaGestion['fecha_sugerida'] = $request['fecha_sugerida'];
                    $nuevaGestion['fecha_solicita_afiliado'] = $request['fecha_solicitada_afiliado'];
                    $nuevaGestion['cirujano'] = $request['cirujano'];
                    $nuevaGestion['especialidad'] = $request['especialidad'];
                    $nuevaGestion['fecha_preanestesia'] = $request['fecha_preanestesia'];
                    $nuevaGestion['fecha_cirugia'] = $request['fecha_cirugia'];
                    $nuevaGestion['fecha_ejecucion'] = $request['fecha_ejecucion'];
                    $nuevaGestion->save();
                    if (isset($request['adjuntos'])) {
                        $archivos = $request['adjuntos'];
                        $ruta = 'adjuntosGestionOrden/'.$ordenProcedimientoId.'/programada';
    
                        foreach ($archivos as $archivo) {
                            $nombre = $archivo->getClientOriginalName();
                            $subirArchivo = $this->subirArchivoNombre($ruta, $archivo, $nombre, 'server37');
                            $adjunto = $this->AdjuntoGestionOrdenRepository->crear([
                                'nombre' => $nombre,
                                'ruta' => $subirArchivo,
                                'gestion_orden_id' => $nuevaGestion->id
                            ]);
                        }
                    }

                }
                break;
            case 19:
                foreach($request['id'] as $ordenProcedimientoId){
                    
                    $nuevaGestion = new GestionOrdenPrestador();
    
                    if ($request['tipoOrden'] == 'servicio') {
                        $nuevaGestion['orden_procedimiento_id'] = $ordenProcedimientoId;
    
                        $ordenProcedimiento = OrdenProcedimiento::find($ordenProcedimientoId);
                        $ordenProcedimiento['estado_id_gestion_prestador'] = $estado;
                        $ordenProcedimiento->save();
                    } else {
                        $nuevaGestion['orden_codigo_propio_id'] = $ordenProcedimientoId;
    
                        $ordenCodigoPropio = OrdenCodigoPropio::find($ordenProcedimientoId);
                        $ordenCodigoPropio['estado_id_gestion_prestador'] = $estado;
                        $ordenCodigoPropio->save();
                    }
    
                    $nuevaGestion['estado_gestion_id'] = $request['estado'];
                    $nuevaGestion['observacion'] = $request['observaciones'];
                    $nuevaGestion['funcionario_responsable'] = $request['funcionario_responsable'];
                    $nuevaGestion['funcionario_gestiona'] = auth()->user()->id;
                    $nuevaGestion->save();
                }
        }
    }
    public function listarGestionPrestador($datos)
    {
        $gestionesPorPrestador = $this->model->select(
            'gestion_orden_prestador.id',
            'gestion_orden_prestador.orden_procedimiento_id',
            'gestion_orden_prestador.orden_codigo_propio_id',
            'gestion_orden_prestador.observacion',
            'gestion_orden_prestador.estado_gestion_id',
            'estados.nombre as estado',
            'gestion_orden_prestador.observacion',
            'gestion_orden_prestador.funcionario_responsable',
            'gestion_orden_prestador.funcionario_gestiona',
            'gestion_orden_prestador.fecha_cancelacion',
            'gestion_orden_prestador.motivo_cancelacion',
            'gestion_orden_prestador.causa_cancelacion',
            'gestion_orden_prestador.fecha_sugerida',
            'gestion_orden_prestador.fecha_solicita_afiliado',
            'gestion_orden_prestador.fecha_resultado',
            'gestion_orden_prestador.cirujano',
            'gestion_orden_prestador.especialidad',
            'gestion_orden_prestador.fecha_preanestesia',
            'gestion_orden_prestador.fecha_cirugia',
            'gestion_orden_prestador.fecha_ejecucion',
            'gestion_orden_prestador.fecha_asistencia',
            'gestion_orden_prestador.created_at',
            // 'ago.ruta'
        )
            ->selectRaw("CASE WHEN cups.id IS NOT NULL THEN CONCAT(cups.codigo,' - ',cups.nombre) WHEN codigo_propios.id IS NOT NULL THEN CONCAT(codigo_propios.codigo,' - ',codigo_propios.nombre) ELSE NULL END as cup")
            // ->leftjoin('adjuntos_gestion_ordens as ago', 'ago.gestion_orden_id', 'gestion_orden_prestador.id')
            ->leftjoin('orden_procedimientos', 'gestion_orden_prestador.orden_procedimiento_id', 'orden_procedimientos.id')
            ->leftjoin('orden_codigo_propios', 'gestion_orden_prestador.orden_codigo_propio_id', 'orden_codigo_propios.id')
            ->leftjoin('cups', 'cups.id', '=', 'orden_procedimientos.cup_id')
            ->leftjoin('codigo_propios', 'codigo_propios.id', '=', 'orden_codigo_propios.codigo_propio_id')
            ->where(function ($query) use ($datos) {
                $query->whereIn('orden_procedimientos.id', $datos['ordenes'])
                    ->orWhereIn('orden_codigo_propios.id', $datos['ordenes']);
            })
            ->join('estados', 'gestion_orden_prestador.estado_gestion_id', 'estados.id')
            ->with('adjuntos')
            ->orderBy('gestion_orden_prestador.id', 'desc')
            ->get();

        return $gestionesPorPrestador;
    }

    public function reporteOrdenesPrestadores($request)
    {
        $asistencia = Collect(DB::select('select * from fn_reporte_detalle_prestadores (?,?,?,?)', [$request['desde'], $request['hasta'],$request['sede']['id'],$request['servicioClinica']]));
        $asistenciaPropio = Collect(DB::select('select * from fn_reporte_detalle_prestadores_codigos_propios (?,?,?,?)', [$request['desde'], $request['hasta'],$request['sede']['id'],$request['servicioClinica']]));
        $array1 = json_decode($asistencia, true);
        $array2 = json_decode($asistenciaPropio, true);
        return array_merge($array1,$array2);
    }
}
