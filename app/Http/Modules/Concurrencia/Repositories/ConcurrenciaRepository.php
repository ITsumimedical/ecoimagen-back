<?php

namespace App\Http\Modules\Concurrencia\Repositories;

use App\Http\Modules\Bases\RepositoryBase;
use App\Http\Modules\Concurrencia\Models\CambiosConcurrencias;
use App\Http\Modules\Concurrencia\Models\ComplementoIngreso;
use App\Http\Modules\Concurrencia\Models\Concurrencia;
use App\Http\Modules\Concurrencia\Models\IngresoConcurrencia;
use App\Http\Modules\Concurrencia\Models\OrdenConcurrencia;
use App\Http\Modules\Concurrencia\Models\SeguimientoConcurrencia;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class ConcurrenciaRepository extends RepositoryBase
{

    public function __construct(
        protected Concurrencia $concurrenciaModel,
        protected SeguimientoConcurrencia $seguimientoConcurrenciaModel,
        protected IngresoConcurrencia $ingresoConcurrenciaModel,
        protected OrdenConcurrencia $ordenConcurrenciaModel,
        protected CambiosConcurrencias $cambiosConcurrenciasModel,
        protected ComplementoIngreso $complementoIngresoModel)
    {
        parent::__construct(
            $concurrenciaModel,
            $complementoIngresoModel,
            $ingresoConcurrenciaModel,
            $cambiosConcurrenciasModel,
        );
    }

    public function crearIngreso($request)
    {
       $ingreso = IngresoConcurrencia::create([
          'afiliado_id' => $request['afiliado_id'],
          'fecha_ingreso' => $request['fecha_ingreso'],
          'cie10_id' => $request['cie10_id'],
          'tipo_hospitalizacion' => $request['tipo_hospitalizacion'],
          'unidad_funcional' => $request['unidad_funcional'],
          'via_ingreso' => $request['via_ingreso'],
          'reingreso_15_dias' => $request['reingreso_15_dias'],
          'reingreso_30_dias' => $request['reingreso_30_dias'],
          'rep_id' => $request['rep_id'],
          'cama_piso' => $request['cama_piso'],
          'codigo_hospitalizacion' => $request['codigo_hospitalizacion'],
          'estancia_total' => $request['estancia_total'],
          'especialidad_id' => $request['especialidad_id'],
          'peso_neonato' => $request['peso_neonato'],
          'edad_gestacional' => $request['edad_gestacional'],
          'nota_seguimiento' => $request['nota_seguimiento'],
          'user_id' => Auth::id(),
       ]);
       return $ingreso;
    }

    public function crearConcurrencia($request)
    {
       $ingreso = Concurrencia::create([
          'costo_atencion' => $request['costo_atencion'],
          'fecha_egreso' => $request['fecha_egreso'],
          'destino_egreso' => $request['destino_egreso'],
          'dias_estancia_observacion' => $request['dias_estancia_observacion'],
          'dias_estancia_intensivo' => $request['dias_estancia_intensivo'],
          'dias_estancia_intermedio' => $request['dias_estancia_intermedio'],
          'dias_estancia_basicos' => $request['dias_estancia_basicos'],
          'hospitalizacion_evitable' => $request['hospitalizacion_evitable'],
          'reporte_patologia_diagnostica' => $request['reporte_patologia_diagnostica'],
          'alto_costo' => $request['alto_costo'],
          'costo_total_global' => $request['costo_total_global'],
          'numero_factura' => $request['numero_factura'],
          'auditor_id' => Auth::id(),
          'dx_egreso' => $request['dx_egreso'],
          'dx_concurrencia' => $request['dx_concurrencia'],
          'estado_id' => $request['estado_id'],
          'ingreso_concurrencia_id' => $request['ingreso_concurrencia_id'],
        ]);
        return $ingreso;
    }

    public function listarIngreso($request) {
        $consulta = $this->ingresoConcurrenciaModel->select(
            'ingreso_concurrencias.*',
            DB::raw("TO_CHAR(ingreso_concurrencias.created_at, 'yyyy-MM-dd') as fecha_creacion"),
            DB::raw("TO_CHAR(ingreso_concurrencias.fecha_ingreso, 'yyyy-MM-dd') as fecha_ingreso_formateada"))
        ->leftJoin('concurrencias', 'concurrencias.ingreso_concurrencia_id', '=', 'ingreso_concurrencias.id')
        ->with([
            'afiliado',
            'rep',
            'especialidad',
            'cie10'
        ])
        ->where(function ($query) {
            $query->whereNull('concurrencias.id')
                  ->orWhere('concurrencias.estado_id', '!=', 52);
        });

        return $request->page ? $consulta->paginate($request->cant) : $consulta->get();
    }

    public function actualizarIngreso($request) {
        $ingresoActual = $this->ingresoConcurrenciaModel->find($request->id);

        $actualizaciones = [];

        if ($ingresoActual->fecha_ingreso != $request['fecha_ingreso']) {
            $actualizaciones[] = "Se cambia el campo Fecha de ingreso de ({$ingresoActual->fecha_ingreso}) por ({$request['fecha_ingreso']})";
        }
        if ($ingresoActual->cie10_id != $request['cie10_id']) {
            $actualizaciones[] = "Se cambia el campo CIE10 de ({$ingresoActual->cie10_id}) por ({$request['cie10_id']})";
        }
        if ($ingresoActual->tipo_hospitalizacion != $request['tipo_hospitalizacion']) {
            $actualizaciones[] = "Se cambia el campo Tipo de Hospitalización de ({$ingresoActual->tipo_hospitalizacion}) por ({$request['tipo_hospitalizacion']})";
        }
        if ($ingresoActual->unidad_funcional != $request['unidad_funcional']) {
            $actualizaciones[] = "Se cambia el campo Unidad Funcional de ({$ingresoActual->unidad_funcional}) por ({$request['unidad_funcional']})";

            $concurrencia = $this->concurrenciaModel->where('ingreso_concurrencia_id', $ingresoActual->id)->first();

            if ($concurrencia) {
                $ultimoCambio = $this->cambiosConcurrenciasModel
                    ->where('ingreso_concurrencia_id', $ingresoActual->id)
                    ->orderBy('created_at', 'desc')
                    ->first();

                $fechaBase = $ultimoCambio ? \Carbon\Carbon::parse($ultimoCambio->fecha_aplicacion) : \Carbon\Carbon::parse($ingresoActual->fecha_ingreso);
                $diasEstanciaTotal = $fechaBase->diffInDays($request->fecha_aplicacion);

                $diasEstanciaPrevios = 0;

                switch ($ingresoActual->unidad_funcional) {
                    case 'HOSPITALIZACIÓN OBSTÉTRICA':
                    case 'HOSPITALIZACIÓN':
                        $diasEstanciaPrevios = $concurrencia->dias_estancia_basicos ?? 0;
                        break;

                    case 'INTERMEDIO ADULTO':
                    case 'INTERMEDIO NEONATAL':
                    case 'INTERMEDIO PEDRIATRÍA':
                        $diasEstanciaPrevios = $concurrencia->dias_estancia_intermedio ?? 0;
                        break;

                    case 'UCI ADULTO':
                    case 'UCI NEONATAL':
                    case 'UCI PEDIATRÍA':
                        $diasEstanciaPrevios = $concurrencia->dias_estancia_intensivo ?? 0;
                        break;
                }

                $diasEstanciaNuevos = max(0, $diasEstanciaTotal - $diasEstanciaPrevios);

                switch ($ingresoActual->unidad_funcional) {
                    case 'HOSPITALIZACIÓN OBSTÉTRICA':
                    case 'HOSPITALIZACIÓN':
                        if ($diasEstanciaNuevos > 0) {
                            $concurrencia->dias_estancia_basicos += $diasEstanciaNuevos;
                            $actualizaciones[] = "Se actualiza el campo días de estancia básicos a {$concurrencia->dias_estancia_basicos} días.";
                        }
                        break;

                    case 'INTERMEDIO ADULTO':
                    case 'INTERMEDIO NEONATAL':
                    case 'INTERMEDIO PEDRIATRÍA':
                        if ($diasEstanciaNuevos > 0) {
                            $concurrencia->dias_estancia_intermedio += $diasEstanciaNuevos;
                            $actualizaciones[] = "Se actualiza el campo días de estancia intermedio a {$concurrencia->dias_estancia_intermedio} días.";
                        }
                        break;

                    case 'UCI ADULTO':
                    case 'UCI NEONATAL':
                    case 'UCI PEDIATRÍA':
                        if ($diasEstanciaNuevos > 0) {
                            $concurrencia->dias_estancia_intensivo += $diasEstanciaNuevos;
                            $actualizaciones[] = "Se actualiza el campo días de estancia intensivo a {$concurrencia->dias_estancia_intensivo} días.";
                        }
                        break;

                    default:
                        break;
                }

                $concurrencia->save();

                $ingresoActual->unidad_funcional = $request->unidad_funcional;
                $ingresoActual->save();
            }
        }

        if ($ingresoActual->via_ingreso != $request['via_ingreso']) {
            $actualizaciones[] = "Se cambia el campo Vía de Ingreso de ({$ingresoActual->via_ingreso}) por ({$request['via_ingreso']})";
        }
        if ($ingresoActual->reingreso_15_dias != $request['reingreso_15_dias']) {
            $actualizaciones[] = "Se cambia el campo Reingreso a 15 días de ({$ingresoActual->reingreso_15_dias}) por ({$request['reingreso_15_dias']})";
        }
        if ($ingresoActual->reingreso_30_dias != $request['reingreso_30_dias']) {
            $actualizaciones[] = "Se cambia el campo Reingreso a 30 días de ({$ingresoActual->reingreso_30_dias}) por ({$request['reingreso_30_dias']})";
        }
        if ($ingresoActual->rep_id != $request['rep_id']) {
            $actualizaciones[] = "Se cambia el campo Rep de ({$ingresoActual->rep_id}) por ({$request['rep_id']})";
        }
        if ($ingresoActual->cama_piso != $request['cama_piso']) {
            $actualizaciones[] = "Se cambia el campo Cama Piso de ({$ingresoActual->cama_piso}) por ({$request['cama_piso']})";
        }
        if ($ingresoActual->codigo_hospitalizacion != $request['codigo_hospitalizacion']) {
            $actualizaciones[] = "Se cambia el campo Código de Hospitalización de ({$ingresoActual->codigo_hospitalizacion}) por ({$request['codigo_hospitalizacion']})";
        }
        if ($ingresoActual->estancia_total != $request['estancia_total']) {
            $actualizaciones[] = "Se cambia el campo Estancia Total de ({$ingresoActual->estancia_total}) por ({$request['estancia_total']})";
        }
        if ($ingresoActual->especialidad_id != $request['especialidad_id']) {
            $actualizaciones[] = "Se cambia el campo Especialidad de ({$ingresoActual->especialidad_id}) por ({$request['especialidad_id']})";
        }
        if ($ingresoActual->nota_seguimiento != $request['nota_seguimiento']) {
            $actualizaciones[] = "Se cambia el campo Nota de Seguimiento de ({$ingresoActual->nota_seguimiento}) por ({$request['nota_seguimiento']})";
        }

        $this->ingresoConcurrenciaModel->where('id', $request->id)->update([
            'fecha_ingreso' => $request['fecha_ingreso'],
            'cie10_id' => $request['cie10_id'],
            'tipo_hospitalizacion' => $request['tipo_hospitalizacion'],
            'unidad_funcional' => $request['unidad_funcional'],
            'via_ingreso' => $request['via_ingreso'],
            'reingreso_15_dias' => $request['reingreso_15_dias'],
            'reingreso_30_dias' => $request['reingreso_30_dias'],
            'rep_id' => $request['rep_id'],
            'cama_piso' => $request['cama_piso'],
            'codigo_hospitalizacion' => $request['codigo_hospitalizacion'],
            'estancia_total' => $request['estancia_total'],
            'especialidad_id' => $request['especialidad_id'],
            'peso_neonato' => $request['peso_neonato'],
            'edad_gestacional' => $request['edad_gestacional'],
            'nota_seguimiento' => $request['nota_seguimiento'],
        ]);

        if (!empty($actualizaciones)) {
            DB::table('cambios_concurrencias')->insert([
                'user_id' => Auth::id(),
                'fecha_aplicacion' => $request->fecha_aplicacion ?? Carbon::now(),
                'ingreso_concurrencia_id' => $request->id,
                'created_at' => Carbon::now(),
                'actualizacion' => implode(', ', $actualizaciones)
            ]);
        }
    }

    public function actualizarConcurrencia($request)
    {
        $concurrenciaAnterior = $this->concurrenciaModel->where('ingreso_concurrencia_id', $request->ingreso_concurrencia_id)->first();

        $actualizaciones = [];

        if ($concurrenciaAnterior->alto_costo != $request->alto_costo) {
            $actualizaciones[] = "Se cambia el campo Alto Costo de {$concurrenciaAnterior->alto_costo} por {$request->alto_costo}";
        }
        if ($concurrenciaAnterior->costo_atencion != $request->costo_atencion) {
            $actualizaciones[] = "Se cambia el campo Costo de Atención de {$concurrenciaAnterior->costo_atencion} por {$request->costo_atencion}";
        }
        if ($concurrenciaAnterior->reporte_patologia_diagnostica != $request->reporte_patologia_diagnostica) {
            $actualizaciones[] = "Se cambia el campo Reporte Patología Diagnóstica de {$concurrenciaAnterior->reporte_patologia_diagnostica} por {$request->reporte_patologia_diagnostica}";
        }
        if ($concurrenciaAnterior->hospitalizacion_evitable != $request->hospitalizacion_evitable) {
            $actualizaciones[] = "Se cambia el campo Hospitalización Evitable de {$concurrenciaAnterior->hospitalizacion_evitable} por {$request->hospitalizacion_evitable}";
        }
        if ($concurrenciaAnterior->dx_concurrencia != $request->dx_concurrencia) {
            $actualizaciones[] = "Se cambia el campo Diagnóstico Concurrencia de {$concurrenciaAnterior->dx_concurrencia} por {$request->dx_concurrencia}";
        }
        if ($concurrenciaAnterior->dx_egreso != $request->dx_egreso) {
            $actualizaciones[] = "Se cambia el campo Diagnóstico Egreso de {$concurrenciaAnterior->dx_egreso} por {$request->dx_egreso}";
        }
        if ($concurrenciaAnterior->destino_egreso != $request->destino_egreso) {
            $actualizaciones[] = "Se cambia el campo Destino Egreso de {$concurrenciaAnterior->destino_egreso} por {$request->destino_egreso}";
        }
        if ($concurrenciaAnterior->estado_id != $request->estado_id) {
            $actualizaciones[] = "Se cambia el campo Estado de {$concurrenciaAnterior->estado_id} por {$request->estado_id}";
        }

        if (!empty($actualizaciones)) {
            DB::table('cambios_concurrencias')->insert([
                'user_id' => Auth::id(),
                'fecha_aplicacion' => $request->fecha_aplicacion,
                'concurrencia_id' => $concurrenciaAnterior->id,
                'actualizacion' => implode(', ', $actualizaciones),
            ]);
        }

        return $this->concurrenciaModel->where('ingreso_concurrencia_id', $request->ingreso_concurrencia_id)->update([
            'alto_costo' => $request->alto_costo,
            'costo_atencion' => $request->costo_atencion,
            'reporte_patologia_diagnostica' => $request->reporte_patologia_diagnostica,
            'hospitalizacion_evitable' => $request->hospitalizacion_evitable,
            'dx_concurrencia' => $request->dx_concurrencia,
            'dx_egreso' => $request->dx_egreso,
            'destino_egreso' => $request->destino_egreso,
            'ingreso_concurrencia_id' => $request->ingreso_concurrencia_id,
            'estado_id' => $request->estado_id,
        ]);
    }

    public function actualizarSeguimiento($request){
        return $this->seguimientoConcurrenciaModel->where('seguimiento_concurrencias.id',$request->id)->update([
            'nota_dss' => $request['nota_dss'],
            'nota_aac' => $request['nota_aac'],
            'nota_lc' => $request['nota_lc'],
            'concurrencia_id' => $request['concurrencia_id'],
            'user_notadss_id' => $request['user_notadss_id'],
            'user_notaaac_id' => $request['user_notaaac_id'],
            'user_notalc_id' => $request['user_notalc_id'],
            'nota_ingreso' => $request['nota_ingreso'],
        ]);
    }

    public function contadorSeguimientos()
    {
        $total = $this->concurrenciaModel->where('estado_id', 19)->count();
        $sumaTotal = $this->concurrenciaModel->where('estado_id', 19)->sum('costo_atencion');
        $consulta =$this->concurrenciaModel->select(DB::raw("DATEDIFF(DAY,concurrencias.fecha_ingreso,GETDATE()) as dias_estancia"))
            ->where('estado_id', 19)
            ->get();

        $menos_4 = $consulta->whereIn('dias_estancia', [0, 1, 2, 3])->count();
        $suma_4 = $consulta->whereIn('dias_estancia', [0, 1, 2, 3])->sum('costo_atencion');
        $entre4_5 = $consulta->whereIn('dias_estancia', [4, 5])->count();
        $suma_4_5 = $consulta->whereIn('dias_estancia', [4, 5])->sum('costo_atencion');
        $mayor_5 = $consulta->where('dias_estancia', '>', 5)->count();
        $suma_5 = $consulta->where('dias_estancia', '>', 5)->sum('costo_atencion');

            return (Object)[
                'total' => $total,
                'sumaTotal'=> $sumaTotal,
                'menos_4' =>$menos_4,
                'suma_4' => $suma_4,
                'entre4_5' => $entre4_5,
                'suma_4_5' => $suma_4_5,
                'mayor_5' => $mayor_5,
                'suma_5' => $suma_5,
            ];
    }

    public function listarConcurrencias()
    {
        $consulta = $this->concurrenciaModel->select('concurrencias.*')
            ->selectRaw("DATEDIFF(DAY,concurrencias.fecha_ingreso,GETDATE()) as dias_estancia")
            ->where('estado_id', 19)
            ->get();
        return $consulta;
    }

    public function listarConcurrenciasIngreso($id)
    {
        $consulta = $this->concurrenciaModel->select('concurrencias.*')
            ->where('ingreso_concurrencia_id', $id)
            ->with('cie10')
            ->first();
        return $consulta;
    }

    public function listarComplementos($id)
    {
        $consulta = $this->complementoIngresoModel->select('complemento_ingresos.*')
            ->where('ingreso_concurrencia_id', $id)
            ->get();
        return $consulta;
    }

    public function guardarComplementoConcurrencia($request)
    {
       $complemento = ComplementoIngreso::create([
          'peso_neonato' => $request['peso_neonato'],
          'edad_gestacional' => $request['edad_gestacional'],
          'ingreso_concurrencia_id' => $request['ingreso_concurrencia_id']
       ]);
       return $complemento;
    }

    public function eliminarComplementoConcurrencia($request){
        return $this->complementoIngresoModel->where('complemento_ingresos.id',$request->id)->update([
            'deleted_at' => Carbon::now()
        ]);
    }

    public function guardarOrdenamientoConcurrencia($request)
    {
       $ingreso = OrdenConcurrencia::create([
          'cup_id' => $request['cup_id'],
          'costo' => $request['costo'],
          'cantidad' => $request['cantidad'],
          'user_id' => Auth::id(),
          'ingreso_concurrencia_id' => $request['ingreso_concurrencia_id'],
       ]);
       return $ingreso;
    }

    public function listarOrdenes($id)
    {
        $consulta = $this->ordenConcurrenciaModel->select('orden_concurrencias.*')
            ->where('ingreso_concurrencia_id', $id)
            ->with(['cup', 'user.operador'])
            ->get();
        return $consulta;
    }

    public function eliminarOrden($request){
        return $this->ordenConcurrenciaModel->where('orden_concurrencias.id',$request->id)->update([
            'deleted_at' => Carbon::now()
        ]);
    }

    public function guardarSeguimiento($request)
    {
       $seguimiento = SeguimientoConcurrencia::create([
          'notas' => $request['notas'],
          'nota_dss' => $request['nota_dss'],
          'nota_aac' => $request['nota_aac'],
          'nota_lc' => $request['nota_lc'],
          'nota_ingreso' => $request['nota_ingreso'],
          'concurrencia_id' => $request['concurrencia_id'],
          'user_id' => Auth::id(),
          'user_notadss_id' => $request['user_notadss_id'],
          'user_notaaac_id' => $request['user_notaaac_id'],
          'user_notalc_id' => $request['user_notalc_id'],
       ]);
       return $seguimiento;
    }

    public function listarSeguimiento($id)
    {
        $consulta = $this->seguimientoConcurrenciaModel->select('seguimiento_concurrencias.*')
            ->where('concurrencia_id', $id)
            ->with([
                'usuarioCrea.operador',
                'usuarioDss.operador',
                'usuarioAac.operador',
                'usuarioLc.operador',
                'concurrencia'
            ])
            ->get();

        return $consulta;
    }

    public function listarAlta($request)
    {
        $consulta = $this->concurrenciaModel
            ->select('concurrencias.*')
            ->with([
                'cie10',
                'dxEgreso',
                'seguimientos.usuarioCrea.operador',
                'seguimientos.usuarioAac.operador',
                'seguimientos.usuarioDss.operador',
                'ingresoConcurrencia' => function ($query) {
            $query->with([
            'afiliado',
            'especialidad',
            'rep',
            'cie10',
            'ordenConcurrencias.cup',
            'ordenConcurrencias.user.operador',
            'evento.user.operador',
            'evento.userElimina.operador',
            'costoEvitado',
            'costoEvitable']);
        }])
            ->where('estado_id', 52)
            ->when($request->numero_documento, function ($query, $numero_documento) {
                return $query->whereHas('ingresoConcurrencia.afiliado', function ($query) use ($numero_documento) {
                    $query->where('numero_documento', $numero_documento);
                });
            });

        return $request->page ? $consulta->paginate($request->cant) : $consulta->get();
    }

    public function reabrir($request){
        return $this->concurrenciaModel->where('concurrencias.id',$request->id)->update([
            'estado_id' => 1,
        ]);
    }


}
