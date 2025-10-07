<?php

namespace App\Http\Modules\Ordenamiento\Repositories;

use App\Http\Modules\Afiliados\Models\Afiliado;
use App\Http\Modules\Bases\RepositoryBase;
use App\Http\Modules\CambiosOrdenes\Models\CambiosOrdene;
use App\Http\Modules\CodigoPropios\Models\CodigoPropio;
use App\Http\Modules\Ordenamiento\Models\Orden;
use App\Http\Modules\Ordenamiento\Models\OrdenCodigoPropio;
use App\Http\Modules\Reps\Models\ParametrizacionCupPrestador;
use Carbon\Carbon;
use Error;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class OrdenCodigoPropioRepository extends RepositoryBase
{

    public function __construct(protected OrdenCodigoPropio $ordenCodigoPropioModel, protected Orden $orden)
    {
        parent::__construct($this->ordenCodigoPropioModel);
    }

    public function calcularFecha($id)
    {
        $orden = $this->ordenCodigoPropioModel->join('ordenes', 'orden_codigo_propios.orden_id', 'ordenes.id')->where('orden_codigo_propios.id', $id)->first();
        $fecha = Carbon::now();
        if ($orden->paginacion) {
            $paginacion = explode('/', $orden->paginacion);
            for ($i = intval($paginacion[0]); $i <= intval($paginacion[1]); $i++) {
                $anterior = $this->ordenCodigoPropioModel->join('ordenes', 'orden_codigo_propios.orden_id', 'ordenes.id')->where('ordenes.consulta_id', $orden->consulta_id)->where('ordenes.paginacion', ($i - 1) . "/" . $paginacion[1])->where('autorizacion', $orden->autorizacion)->first();
                $o = $this->ordenCodigoPropioModel->join('ordenes', 'orden_codigo_propios.orden_id', 'ordenes.id')->where('ordenes.consulta_id', $orden->consulta_id)->where('ordenes.paginacion', $i . "/" . $paginacion[1])->where('autorizacion', $orden->autorizacion)->first();
                if ($anterior) {
                    $fechaAnterior = Carbon::parse($anterior->fecha_vigencia);
                    $o->update([
                        'fecha_vigencia' => $fechaAnterior->addDays(28)
                    ]);
                } else {
                    $o->update([
                        'fecha_vigencia' => $fecha->addDays(0)
                    ]);
                }
            }
        } else {
            $orden->update(['fecha_vigencia' => $fecha->toDateTimeString()]);
        }
    }


    public function actualizarRepCodigoPropio($data)
    {
        $ids = is_array($data->id) ? $data->id : [$data->id];
        foreach ($ids as $id) {
            $this->ordenCodigoPropioModel::find($id)->update(['rep_id' => $data['rep_id']]);
            CambiosOrdene::create([
                'orden_codigo_propio_id' => $id,
                'user_id' => Auth::id(),
                'accion' => 'Actualización de direccionamiento',
                'observacion' => 'Se realiza actualización de direccionamiento',
                'rep_anterior_id' => $data->rep_anterior_id
            ]);
        }

        return true;
    }

    public function ordenCodigoPropioSede($request)
    {
        $existenParametrizados = ParametrizacionCupPrestador::where('rep_id', $request['sede']['id'])
            ->when($request['servicioClinica'], fn($q) => $q->where('categoria', $request['servicioClinica']))
            ->exists();

        $queryOrdenes = $this->orden::query()
            ->select('ordenes.id', 'ordenes.consulta_id', 'ordenes.user_id', 'ordenes.estado_id')
            ->join('orden_codigo_propios as op', 'op.orden_id', '=', 'ordenes.id')
            ->whereHas('ordenesCodigoPropio', fn($q) => $q->FiltrarCupsPrestador($request, $existenParametrizados))

            ->when($request['documento'], function ($q, $documento) {
                $q->join('consultas as c', 'c.id', '=', 'ordenes.consulta_id')
                    ->join('afiliados as a', 'a.id', '=', 'c.afiliado_id')
                    ->where('a.numero_documento', $documento);
            })
            ->distinct()
            ->orderByDesc('ordenes.id')

            ->with([
                'ordenesCodigoPropio' => fn($q) => $q->select(
                    'orden_codigo_propios.id',
                    'orden_codigo_propios.codigo_propio_id',
                    'orden_codigo_propios.estado_id',
                    'orden_codigo_propios.rep_id',
                    'orden_codigo_propios.cantidad',
                    'orden_codigo_propios.observacion',
                    'orden_codigo_propios.fecha_vigencia',
                    'orden_codigo_propios.orden_id',
                    'orden_codigo_propios.estado_id_gestion_prestador',
                    'orden_codigo_propios.fecha_ejecucion',
                    'orden_codigo_propios.created_at'

                )
                    ->FiltrarCupsPrestador($request, $existenParametrizados)->distinct(),
                'ordenesCodigoPropio.estadoGestionPrestador:id,nombre',
                'ordenesCodigoPropio.auditoria:id,orden_procedimiento_id,user_id',
                'ordenesCodigoPropio.auditoria.user:id',
                'ordenesCodigoPropio.auditoria.user.operador:id,user_id,nombre,apellido',
                'ordenesCodigoPropio.codigoPropio',
                'ordenesCodigoPropio.estado:id,nombre',
                'consulta:id,afiliado_id,cup_id,diagnostico_principal',
                'consulta.afiliado:id,primer_nombre,primer_apellido,segundo_nombre,segundo_apellido,numero_documento,entidad_id,ips_id,tipo_documento,departamento_afiliacion_id,municipio_afiliacion_id,estado_afiliacion_id,departamento_atencion_id,municipio_atencion_id,tipo_afiliado_id,tipo_afiliacion_id',
                'consulta.afiliado.ips:id,nombre',
                'consulta.afiliado.departamento_afiliacion',
                'consulta.afiliado.departamento_atencion',
                'consulta.afiliado.municipio_afiliacion',
                'consulta.afiliado.municipio_atencion',
                'consulta.afiliado.tipo_afiliacion',
                'consulta.afiliado.tipo_afiliado',
                'consulta.afiliado.EstadoAfiliado',
                'consulta.afiliado.tipoDocumento',
                'consulta.cie10Afiliado:id,consulta_id,cie10_id',
                'consulta.cie10Afiliado.cie10:id,nombre,codigo_cie10',
                'funcionario:id',
                'funcionario.operador:id,user_id,nombre,apellido',
                'consulta.afiliado.entidad:id,nombre',
            ]);

        // $query = ParametrizacionCupPrestador::where('rep_id', $request['sede']);
        // if ($request['servicioClinica']) {
        //     $query->where('categoria', $request['servicioClinica']);
        // }
        // $parametrizacion = $query->get()->toArray();

        // $queryOrdenes = OrdenCodigoPropio::with([
        //     'orden.consulta.afiliado.ips',
        //     'orden.consulta.afiliado.departamento_afiliacion',
        //     'orden.consulta.afiliado.departamento_atencion',
        //     'orden.consulta.afiliado.municipio_afiliacion',
        //     'orden.consulta.afiliado.municipio_atencion',
        //     'orden.consulta.cie10Afiliado.cie10',
        //     'orden.funcionario.operador',
        //     'estadoGestionPrestador',
        //     'auditoria.user.operador',
        //     'codigoPropio',
        //     'orden.consulta.afiliado.entidad',
        //     'orden.consulta.afiliado.tipo_afiliacion',
        //     'orden.consulta.afiliado.tipo_afiliado',
        //     'orden.consulta.afiliado.EstadoAfiliado',
        //     'orden.consulta.afiliado.tipoDocumento',
        //     'estado'
        // ])
        //     ->whereYear('fecha_vigencia', $request['anio'])
        //     ->whereMonth('fecha_vigencia', $request['mes'])
        //     ->where('rep_id', $request['sede']['id'])
        //     ->whereNotIn('estado_id', [5, 3])
        //     ->orderBy('id', 'desc');
        // if (!is_null($request['documento'])) {
        //     $queryOrdenes->whereHas('orden.consulta.afiliado', function ($query) use ($request) {
        //         $query->where('numero_documento', $request['documento']);
        //     });
        // } else {
        //     if (!is_null($request['estado'])) {
        //         $queryOrdenes->where('estado_id_gestion_prestador', $request['estado']);
        //     }
        // }
        // if (!is_null($request['orden_id'])) {
        //     $queryOrdenes->where('id', $request['orden_id']);
        // }
        // if (count($parametrizacion) > 0) {
        //     $queryOrdenes->whereIn('orden_codigo_propios.codigo_propio_id', array_column($parametrizacion, 'codigo_propio_id'));
        // }
        return $queryOrdenes->paginate($request['perPage'],['*'],'page');
    }

    public function actualizarCodigoPropio($request)
    {
        foreach ($request->id as $index => $id) {
            $codigoPropioAnterior = $request->codigo_propio_anterior_id;
            $cantidadMaxOrdenamiento = DB::table('codigo_propios')
                ->where('id', $request->codigo_propio_id['id'])
                ->value('cantidad_max_ordenamiento');
            if ($request->cantidad > $cantidadMaxOrdenamiento) {
                throw new Error('La nueva cantidad no puede superar el límite determinado del codigo propio', 422);
            }
            $this->ordenCodigoPropioModel->where('id', $id)->update([
                'codigo_propio_id' => $request->codigo_propio_id['id'] ?? $codigoPropioAnterior,
                'cantidad' => $request->cantidad,
            ]);

            DB::table('cambios_ordenes')->insert([
                'orden_codigo_propio_id' => $id,
                'user_id' => Auth::user()->id,
                'observacion' => $request->observacion,
                'codigo_propio_anterior_id' => $codigoPropioAnterior,
                'created_at' => now(),
                'updated_at' => now(),
                'accion' => $request->accion
            ]);
        }
    }

    public function agregarCodigoPropio($id, $request)
    {
        $codigo = CodigoPropio::find($request->codigo_propio_id);

        if ($codigo && $request->cantidad > $codigo->cantidad_max_ordenamiento) {
            throw new Error('La cantidad supera la cantidad maxima de ordenamiento que tiene el cup predeterminada', 422);
        }
        $nuevoProcedimiento = new OrdenCodigoPropio();
        $nuevoProcedimiento->orden_id = $id;
        $nuevoProcedimiento->codigo_propio_id = $request->codigo_propio_id;
        $nuevoProcedimiento->estado_id = 3;
        $nuevoProcedimiento->cantidad = $request->cantidad;
        $nuevoProcedimiento->observacion = $request->observacion;
        $nuevoProcedimiento->estado_id_gestion_prestador = 50;
        $nuevoProcedimiento->fecha_vigencia = now();
        $nuevoProcedimiento->save();

        CambiosOrdene::create([
            'orden_codigo_propio_id' => $nuevoProcedimiento->id,
            'user_id' => Auth::id(),
            'accion' => 'Creación de código propio',
            'observacion' => 'Se creó un nuevo procedimiento en la orden'
        ]);

        return true;
    }

    /**
     * Lista los códigos propios de una orden pendientes de auditoria
     * @param int $afiliadoId
     * @param int $ordenId
     * @return Collection
     * @author Thomas
     */
    public function listarCodigosPropiosPorAuditar(int $afiliadoId, int $ordenId): Collection
    {
        $afiliado = Afiliado::findOrFail($afiliadoId);
        $codigosPropios = $this->obtenerCodigosPropiosPorAuditar($ordenId);

        return $codigosPropios->map(function ($orden) use ($afiliado) {
            $orden->esEditable = $this->determinarCodigoPropioEditable($orden, $afiliado);
            return $orden;
        });
    }

    /**
     * Determina si el codigo propio ordenado es editable de acuerdo a su contrato
     * @param OrdenCodigoPropio $orden
     * @param Afiliado $afiliado
     * @return bool
     * @author Thomas
     */
    private function determinarCodigoPropioEditable($orden, $afiliado): bool
    {
        if ($afiliado->entidad_id == 1) {
            return $orden->codigoPropio
                ? $orden->codigoPropio->tarifa->contains('manual_tarifario_id', 5)
                : false;
        }

        return true;
    }

    /**
     * Obtiene los códigos propios por auditar
     * @param int $ordenId
     * @return Collection
     * @author Thomas
     */
    private function obtenerCodigosPropiosPorAuditar(int $ordenId): Collection
    {
        return $this->ordenCodigoPropioModel
            ->with(['codigoPropio.tarifa', 'rep'])
            ->where('orden_id', $ordenId)
            ->where('estado_id', 3)
            ->get();
    }

    /**
     * Lista las notas adicionales de una orden de codigo propio
     * @param int $ordenCodigoPropioId
     * @return Collection
     * @author Thomas
     */
    public function listarNotasAdicionalesOrdenCodigoPropio(int $ordenCodigoPropioId): Collection
    {
        return CambiosOrdene::with(['user.operador'])
            ->where('orden_codigo_propio_id', $ordenCodigoPropioId)
            ->where('accion', 'Creación de nota adicional')
            ->get();
    }


    public function serviciosVigentes($idAfiliado)
    {
        $hoy = Carbon::now();
        $cambio = Carbon::now()->subDays(180);
        //
        return OrdenCodigoPropio::with('codigoPropio', 'codigoPropio.cup', 'orden', 'orden.consulta', 'cobro', 'rep')
            ->whereBetween('fecha_vigencia', [$cambio->format('Y-m-d') . ' 00:00:00.000', $hoy->format('Y-m-d') . ' 23:59:59.999'])
            ->whereHas('orden.consulta', function ($query) use ($idAfiliado) {
                $query->where('afiliado_id', $idAfiliado);
            })
            ->whereHas('cobro', function ($query) use ($idAfiliado) {
                $query->where('estado_id', 1);
            })
            ->orderBy('orden_codigo_propios.created_at', 'desc')
            ->get();
    }

    /**
     * Retorna el código propio si existe en la orden con el código propio indicado, o null si no existe.
     * @param int $ordenId
     * @param int $codigoPropioId
     * @return OrdenCodigoPropio|null
     * @author Thomas
     */
    public function findByCodigoAndOrden(int $ordenId, int $codigoPropioId): ?OrdenCodigoPropio
    {
        return $this->ordenCodigoPropioModel->where('orden_id', $ordenId)
            ->where('codigo_propio_id', $codigoPropioId)
            ->first();
    }

    /**
     * Obtiene la información de un código propio por su ID
     * @param int $idServicio
     * @return OrdenCodigoPropio|null
     * @author kobatime
     */
    public function getOrdenCodigoPropioById(int $idServicio)
    {
        return OrdenCodigoPropio::select('fecha_vigencia', 'c.cup_id as cup', 'rep_id as rep', 'orden_id')
            ->join('codigo_propios as c', 'orden_codigo_propios.codigo_propio_id', 'c.id')
            ->with('orden.consulta.cie10Afiliado.cie10', 'orden.consulta.HistoriaClinica.finalidadConsulta')
            ->find($idServicio);
    }

    /**
     * Actualiza el estado de gestión de la orden
     * @param int $ordenProcedimientoId
     * @param int $estado
     * @return bool
     */
    public function actualizarEstadoGestionPrestador(int $ordenProcedimientoId,int $estado)
    {
        return $this->ordenCodigoPropioModel->where('id',$ordenProcedimientoId)->update(['estado_id_gestion_prestador'=>$estado]);
    }
}
