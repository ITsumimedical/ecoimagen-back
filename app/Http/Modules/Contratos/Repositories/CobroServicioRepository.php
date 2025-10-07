<?php

namespace App\Http\Modules\Contratos\Repositories;

use App\Http\Modules\Bases\RepositoryBase;
use App\Http\Modules\Contratos\Models\CobroServicio;
use App\Http\Modules\Ordenamiento\Models\OrdenProcedimiento;
use Illuminate\Support\Carbon;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;

class CobroServicioRepository extends RepositoryBase
{

    protected $model;

    public function __construct()
    {
        $this->model = new CobroServicio();
        parent::__construct($this->model);
    }

    public function acumuladoAnual($afiliado, $anio)
    {

        return CobroServicio::join('orden_procedimientos as op', 'cobro_servicios.orden_procedimiento_id', 'op.id')
            ->join('ordenes as o', 'op.orden_id', 'o.id')
            ->join('consultas as c', 'o.consulta_id', 'c.id')
            ->where('c.afiliado_id', $afiliado)
            ->where('cobro_servicios.estado_id', 14)
            ->where('tipo', 'copago')
            ->whereBetween('cobro_servicios.fecha_cobro', [$anio . '-01-01', $anio . '-12-31'])
            ->sum('cobro_servicios.valor');
    }

    public function acumuladoAnualSubsidiado($afiliado, $anio)
    {

        return CobroServicio::join('orden_procedimientos as op', 'cobro_servicios.orden_procedimiento_id', 'op.id')
            ->join('ordenes as o', 'op.orden_id', 'o.id')
            ->join('consultas as c', 'o.consulta_id', 'c.id')
            ->where('c.afiliado_id', $afiliado)
            ->where('cobro_servicios.estado_id', 14)
            ->where('tipo', 'copago')
            ->whereBetween('cobro_servicios.fecha_cobro', [$anio . '-01-01', $anio . '-12-31'])
            ->sum('cobro_servicios.valor');
    }

    public function obtenerOrdenesAgrupadas(int $consulta_id, int $familiaId, Carbon $cambio, Carbon $hoy, $estados)
    {
        $entreFechas = [
            $cambio->copy()->startOfDay()->format('Y-m-d H:i:s.u'),
            $hoy->copy()->endOfDay()->format('Y-m-d H:i:s.u')
        ];

        // Paso 1: Agrupar por cup_id
        $agrupadosRaw = OrdenProcedimiento::select(
            'orden_procedimientos.cup_id',
            'cups.nombre as servicio',
            'cups.codigo as codigoServicio',
            DB::raw('SUM(cs.valor) as valor'),
            DB::raw('SUM(orden_procedimientos.cantidad) as cantidad'),
            DB::raw('SUM(orden_procedimientos.cantidad_usada) as cantidad_usada'),
            DB::raw('SUM(orden_procedimientos.cantidad_pendiente) as cantidad_pendiente'),
            DB::raw('MIN(cs.estado_id) as estado_cobro_id'),
            DB::raw('MIN(cs.tipo) as tipo'),
            DB::raw('MIN(estados.nombre) as estado_cobro'),
            DB::raw('MIN(reps.nombre) as prestador')
        )
            ->join('cups', 'orden_procedimientos.cup_id', '=', 'cups.id')
            ->join('cobro_servicios as cs', 'orden_procedimientos.id', '=', 'cs.orden_procedimiento_id')
            ->leftJoin('reps', 'reps.id', '=', 'orden_procedimientos.rep_id')
            ->join('estados', 'estados.id', '=', 'cs.estado_id')
            ->join('cup_familia', 'cups.id', '=', 'cup_familia.cup_id')
            ->where('cup_familia.familia_id', $familiaId)
            ->where('cs.consulta_id', $consulta_id)
            ->whereIn('orden_procedimientos.estado_id', $estados)
            ->where('cs.estado_id', 1)
            ->whereBetween('orden_procedimientos.fecha_vigencia', $entreFechas)
            ->groupBy('orden_procedimientos.cup_id', 'cups.nombre', 'cups.codigo')
            ->get();

        // Paso 2: obtener los IDs de esas órdenes
        $ordenesAgrupadasIds = OrdenProcedimiento::join('cups', 'orden_procedimientos.cup_id', '=', 'cups.id')
            ->join('cup_familia', 'cups.id', '=', 'cup_familia.cup_id')
            ->where('cup_familia.familia_id', $familiaId)
            ->whereIn('orden_procedimientos.estado_id', $estados)
            ->whereBetween('orden_procedimientos.fecha_vigencia', $entreFechas)
            ->pluck('orden_procedimientos.id');

        // Paso 3: añadir detalles a los grupos
        $agrupadosConDetalles = $agrupadosRaw->map(function ($grupo) use ($consulta_id, $entreFechas, $estados) {
            $detalles = OrdenProcedimiento::select(
                'orden_procedimientos.id as orden_procedimiento_id',
                'orden_procedimientos.orden_id',
                'orden_procedimientos.observacion as observaciones',
                'orden_procedimientos.estado_id',
                'reps.nombre as prestador',
                'orden_procedimientos.cantidad',
                'orden_procedimientos.cantidad_usada',
                'orden_procedimientos.cantidad_pendiente',
                'estados.nombre as estado_cobro',
                'cs.estado_id as estado_cobro_id',
                'cs.valor',
                'cs.tipo'
            )
                ->join('cobro_servicios as cs', 'orden_procedimientos.id', '=', 'cs.orden_procedimiento_id')
                ->leftJoin('reps', 'reps.id', '=', 'orden_procedimientos.rep_id')
                ->join('estados', 'estados.id', '=', 'cs.estado_id')
                ->where('orden_procedimientos.cup_id', $grupo->cup_id)
                ->where('cs.consulta_id', $consulta_id)
                ->whereIn('orden_procedimientos.estado_id', $estados)
                ->whereBetween('orden_procedimientos.fecha_vigencia', $entreFechas)
                ->get();

            $grupo->detalles = $detalles;
            return $grupo;
        });

        return [$agrupadosConDetalles, $ordenesAgrupadasIds];
    }

    public function obtenerOrdenesIndividuales(int $consulta_id, Carbon $cambio, Carbon $hoy, Collection $excluirIds, $estados)
    {
        $entreFechas = [
            $cambio->copy()->startOfDay()->format('Y-m-d H:i:s.u'),
            $hoy->copy()->endOfDay()->format('Y-m-d H:i:s.u')
        ];

        if ($excluirIds->isEmpty()) {
            $excluirIds = collect([-1]);
        }

        return OrdenProcedimiento::select(
            'orden_procedimientos.id as orden_procedimiento_id',
            'orden_procedimientos.orden_id',
            'orden_procedimientos.cup_id',
            'orden_procedimientos.observacion as observaciones',
            'orden_procedimientos.estado_id',
            'reps.nombre as prestador',
            'orden_procedimientos.cantidad',
            'orden_procedimientos.cantidad_usada',
            'orden_procedimientos.cantidad_pendiente',
            'cups.nombre as servicio',
            'cups.codigo as codigoServicio',
            'estados.nombre as estado_cobro',
            'cs.estado_id as estado_cobro_id',
            'cs.valor',
            'cs.tipo'
        )
            ->join('cups', 'orden_procedimientos.cup_id', '=', 'cups.id')
            ->join('cobro_servicios as cs', 'orden_procedimientos.id', '=', 'cs.orden_procedimiento_id')
            ->leftJoin('reps', 'reps.id', '=', 'orden_procedimientos.rep_id')
            ->join('estados', 'estados.id', '=', 'cs.estado_id')
            ->where('cs.consulta_id', $consulta_id)
            ->where('cs.estado_id', 1)
            ->whereIn('orden_procedimientos.estado_id', $estados)
            ->whereBetween('orden_procedimientos.fecha_vigencia', $entreFechas)
            ->whereNotIn('orden_procedimientos.id', $excluirIds)
            ->get();
    }
}
