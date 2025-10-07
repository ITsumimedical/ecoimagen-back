<?php

namespace App\Http\Modules\Bodegas\Repositories;

use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Rap2hpoutre\FastExcel\FastExcel;
use PhpParser\Node\Expr\AssignOp\Concat;
use App\Http\Modules\Bases\RepositoryBase;
use App\Http\Modules\Usuarios\Models\User;
use App\Http\Modules\Bodegas\Models\Bodega;
use App\Http\Modules\Ordenamiento\Models\Orden;
use App\Http\Modules\Medicamentos\Models\Codesumi;
use App\Http\Modules\Movimientos\Models\Movimiento;
use App\Http\Modules\Medicamentos\Models\Medicamento;
use App\Http\Modules\Ordenamiento\Models\OrdenArticulo;
use App\Http\Modules\Movimientos\Models\DetalleMovimiento;
use App\Http\Modules\Medicamentos\Models\BodegaMedicamento;
use App\Http\Modules\InventarioFarmacia\Models\InventarioFarmacia;

class BodegaRepository extends RepositoryBase
{
    protected $ordenModel;
    protected $bodegaModel;

    public function __construct(Orden $orden)
    {
        $this->ordenModel = $orden;
        $this->bodegaModel = new Bodega();
        parent::__construct($this->bodegaModel);
    }


    public function inventarioBodega($data)
    {
        $inventario = BodegaMedicamento::select(
            'bodegas.nombre',
            'bodega_medicamentos.id as bodegaMedicamento',
            'bodega_medicamentos.bodega_id',
            'bodega_medicamentos.medicamento_id',
            'bodega_medicamentos.cantidad_total',
            'lotes.cantidad',
            'lotes.id as lote',
            'lotes.fecha_vencimiento',
            'lotes.codigo'
        )
            ->selectRaw('(select precio_unidad from precio_proveedor_medicamentos where precio_proveedor_medicamentos.medicamento_id = bodega_medicamentos.medicamento_id LIMIT 1) as precio_unidad')
            ->join('bodegas', 'bodega_medicamentos.bodega_id', 'bodegas.id')
            ->join('lotes', 'lotes.bodega_medicamento_id', 'bodega_medicamentos.id')
            ->with(['medicamento', 'medicamento.invima:cum_validacion,titular,descripcion_comercial,producto', 'medicamento.codesumi:id,nombre,codigo'])
            ->where('lotes.cantidad', '>', 0)
            ->where('bodegas.estado_id', 1);
        if ($data['bodega_id'] != 0) {
            $inventario->where('bodega_medicamentos.bodega_id', $data['bodega_id']);
        }
        return $inventario->get();
    }

    public function articulosBodega($data)
    {

        return Codesumi::select(['codesumis.', 'da.'])
            ->join('medicamentos as da', 'da.codesumi_id', 'codesumis.id')
            ->join('bodega_medicamentos as ba', 'ba.medicamento_id', 'da.id')
            ->whereNotNull('codesumis.codigo')
            ->whereNotNull('codesumis.requiere_autorizacion')
            ->whereNotNull('codesumis.nivel_ordenamiento')
            ->where('ba.bodega_id', $data['bodega_id'])
            ->where('codesumis.nombre', 'ILIKE', '%' . $data['nombre'] . '%')
            ->where('codesumis.estado_id', 1)
            ->distinct()
            ->count();
    }

    public function actualizarBodega($data, $id)
    {
        $bodega = $this->bodegaModel::find($id);
        return $bodega->update([
            'nombre' => $data['nombre'],
            'municipio_id' => $data['municipio_id'],
            'tipo_bodega_id' => $data['tipo_bodega_id'],
            'telefono' => $data['telefono'],
            'direccion' => $data['direccion'],
            'hora_inicio' => $data['hora_inicio'],
            'hora_fin' => $data['hora_fin'],
            'stock_seguridad' => $data['stock_seguridad'],
            'tiempo_reposicion' => $data['tiempo_reposicion'],
            'cobertura' => $data['cobertura'],
            'rep_id' => $data['rep_id'],
            'ferrocarriles' => $data['ferrocarriles'],
        ]);
    }

    public function listarCodesumi($request)
    {
        $consulta =  Codesumi::whereNombreOrCodigo($request);
        return $consulta->get();
    }

    public function kardex($data)
    {

        $bodega_id = $data['bodega_id'];
        $codigo = $data['codigo'];
        $fechaDesde = $data['fechaDesde'];
        $fechaHasta = $data['fechaHasta'];
        $factura = $data['factura'] ?? null;

        $kardexQuery = Movimiento::select(
            'b.nombre AS bodega',
            DB::raw("CONCAT(op.nombre,' ',op.apellido) as Responsable"),
            'movimientos.codigo_factura AS codigo_factura',
            'movimientos.orden_id',
            'movimientos.solicitud_bodega_id',
            'movimientos.created_at AS creacion_movimiento',
            'tm.nombre AS transaccion',
            'dm.movimiento_id',
            'dm.cantidad_solicitada AS cantidad_solicitada',
            'dm.cantidad_final AS cantidad_final',
            'dm.cantidad_anterior AS cantidad_anterior',
            'dm.precio_unidad AS precio_unidad',
            'dm.valor_total AS valor_total',
            'dm.valor_promedio AS valor_promedio',
            'lt.codigo AS numero_lote',
            'lt.fecha_vencimiento',
            'cs.nombre AS medicamento',
            'b1.nombre AS bodega_origen',
            'b2.nombre AS bodega_destino'
        )
            ->JOIN('tipo_movimientos as tm', 'tm.id', 'movimientos.tipo_movimiento_id')
            ->JOIN('detalle_movimientos as dm', 'dm.movimiento_id', 'movimientos.id')
            ->JOIN('bodega_medicamentos as bm', 'bm.id', 'dm.bodega_medicamento_id')
            ->JOIN('medicamentos as md', 'md.id', 'bm.medicamento_id')
            ->JOIN('bodegas as b', 'b.id', 'bm.bodega_id')
            ->JOIN('codesumis as cs', 'cs.id', 'md.codesumi_id')
            ->JOIN('operadores as op', 'op.user_id', 'movimientos.user_id')
            ->LEFTJOIN('bodegas as b1', 'b1.id', 'movimientos.bodega_origen_id')
            ->LEFTJOIN('bodegas as b2', 'b2.id', 'movimientos.bodega_destino_id')
            ->LEFTJOIN('lotes as lt', 'lt.id', 'dm.lote_id')
            ->where('cs.estado_id', 1)
            ->whereIn('md.estado_id', [1, 11])
            ->orderBy('movimientos.created_at');

        if ($factura) {
            $kardexQuery->where('movimientos.solicitud_bodega_id', $factura);
        } else {
            $kardexQuery->WHEREBETWEEN('movimientos.created_at', [$fechaDesde, $fechaHasta])
                ->where('b.id', $bodega_id);
        }
        if ($codigo) {
            $kardexQuery->where('cs.codigo', $codigo);
        }

        $kardex = $kardexQuery->get();

        return ['kardex' => $kardex];
    }


    public function minMax($data)
    {
        $dispensados = Medicamento::select([
            'm.codigosumi as Codigo',
            'm.producto',
            'm.6 as v6',
            'm.5 as v5',
            'm.4 as v4',
            'm.3 as v3',
            'm.2 as v2',
            'm.1 as v1',
            DB::raw('COALESCE(SUM(ba.cantidad_total), 0) AS actual'),
            'cs.critico',
            'cs.abc'
        ])
            ->join('codesumis as cs', 'cs.id', 'medicamentos.codesumi_id')
            ->join('min_max as m', 'm.codigosumi', 'cs.codigo')
            ->join('bodega_medicamentos as ba', 'ba.medicamento_id', 'medicamentos.id')
            ->where('m.bodega_id', $data['bodega'])
            ->where('ba.bodega_id', $data['bodega'])
            ->when(!empty($data['codigo']), function ($query) use ($data) {
                return $query->where('cs.codigo', $data['codigo']);
            })
            ->when(!empty($data['producto']), function ($query) use ($data) {
                return $query->where('cs.producto', $data['producto']);
            })
            ->groupBy('m.codigosumi', 'm.producto', 'm.bodega_id', 'm.bodega_nombre', 'm.6', 'm.5', 'm.4', 'm.3', 'm.2', 'm.1', 'cs.critico', 'cs.abc')
            ->get()->toArray();


        $totalDispensados = array_reduce($dispensados, function ($suma, $item) {
            return ($item["v6"] + $item["v5"] + $item["v4"] + $item["v3"] + $item["v2"] + $item["v1"]);
        });


        return ["dispensados" => $dispensados, 'total_dispensados' => intval($totalDispensados)];
    }

    public function exportar($datos)
    {
        $appointments = collect($datos);
        $array = json_decode($appointments, true);
        return (new FastExcel($array))->download('file.xls');
    }

    public function detallesCodesumisReposicion($data)
    {
        return Medicamento::select([
            'medicamentos.id',
            'c.nombre',
            'cums.producto',
            'c.codigo',
            'cums.titular',
            'bd.cantidad_total',
            'bd.id as bodega_medicamento_id',
            'cums.cum_validacion'
        ])
            ->join('codesumis as c', 'c.id', 'medicamentos.codesumi_id')
            ->join('bodega_medicamentos as bd', 'bd.medicamento_id', 'medicamentos.id')
            ->join('cums', 'cums.cum_validacion', 'medicamentos.cum')
            ->where('c.codigo', $data['codigo'])
            ->where('bd.bodega_id', $data['bodega'])
            ->groupBy(
                'medicamentos.id',
                'c.nombre',
                'cums.producto',
                'c.codigo',
                'cums.titular',
                'bd.cantidad_total',
                'bd.id',
                'cums.cum_validacion'
            )
            ->get();
    }

    public function usuarioDispensa($data)
    {
        return User::select([DB::raw("CONCAT(operadores.nombre,' ',operadores.apellido) as nombre"), 'users.id as usuarioId'])
            ->join('operadores', 'operadores.user_id', 'users.id')
            ->where('users.activo', true)
            ->whereIn("users.id", function ($query) use ($data) {
                $query->select('user_id')
                    ->from('movimientos')
                    ->where('tipo_movimiento_id', 5)
                    ->where('bodega_origen_id', $data['bodega_origen_id'])
                    ->distinct();
            })->get();
    }

    public function historicoDispensado($data)
    {
        $objDispensado = Movimiento::select('bodega_origen_id', 'orden_id', 'user_id', 'created_at', 'id')
            ->with([
                'bodegaOrigen:id',
                'orden.consulta.afiliado:id,numero_documento,primer_nombre,segundo_nombre',
                'user.operador'
            ])
            ->where('bodega_origen_id', $data['bodega_origen_id']['id'])
            ->where('tipo_movimiento_id', 5)
            ->whereBetween('created_at', [$data['fecha_inicio'] . ' 00:00:00.000', $data['fecha_final'] . ' 23:59:59.999']);

        if ($data['usuario_id']) {
            $objDispensado->where('user_id', $data['usuario_id']);
        }

        if (isset($data['orden_id'])) {
            $objDispensado->where('orden_id', $data['orden_id']);
        }

        if (isset($data['cedula_paciente'])) {
            $objDispensado->whereHas('orden.consulta.afiliado', function ($query) use ($data) {
                $query->where('numero_documento', $data['cedula_paciente']);
            });
        }

        if (isset($data['medicamento'])) {
            $objDispensado->with(
                'orden.articulos.codesumi'
            )->whereHas('orden.articulos.codesumi', function ($query) use ($data) {
                $query->where('id', $data['medicamento']);
            });
        }

        return $objDispensado->groupBy(
            'bodega_origen_id',
            'orden_id',
            'user_id',
            'created_at',
            'id'
        )->distinct()->get();
    }

    public function historicoDispensadoDetalle($data)
    {
        $detalle = DetalleMovimiento::select([
            'detalle_movimientos.id',
            'detalle_movimientos.created_at',
            'detalle_movimientos.cantidad_anterior',
            'detalle_movimientos.cantidad_final',
            'detalle_movimientos.movimiento_id',
            'lo.codigo',
            'da.cum',
            'cums.producto',
            'co.nombre as medicamento',
        ])
            ->join('lotes as lo', 'detalle_movimientos.lote_id', '=', 'lo.id')
            ->join('bodega_medicamentos as ba', 'detalle_movimientos.bodega_medicamento_id', '=', 'ba.id')
            ->join('medicamentos as da', 'ba.medicamento_id', '=', 'da.id')
            ->join('cums', 'cums.cum_validacion', '=', 'da.cum')
            ->join('movimientos as m', 'm.id', '=', 'detalle_movimientos.movimiento_id')
            ->join('ordenes', 'm.orden_id', '=', 'ordenes.id')
            ->join('orden_articulos as or', 'ordenes.id', '=', 'or.orden_id')
            ->join('codesumis as co', 'or.codesumi_id', '=', 'co.id')
            ->where('ba.bodega_id', $data['bodega_origen_id']['id'])
            ->where('m.orden_id', $data['orden'])
            ->where('m.user_id', $data['usuario_id'])
            ->whereBetween('m.created_at', [$data['fecha_inicio'] . ' 00:00:00.000', $data['fecha_final'] . ' 23:59:59.999']);
        if ($data['usuario_id']) {
            $detalle->where('m.user_id', $data['usuario_id']);
        };
        return response()->json($detalle->get());
    }

    public function listarBodega()
    {
        return $this->bodegaModel::select(
            'bodegas.id',
            'bodegas.municipio_id',
            'bodegas.tipo_bodega_id',
            'bodegas.cobertura',
            'bodegas.tiempo_reposicion',
            'bodegas.stock_seguridad',
            'bodegas.hora_fin',
            'bodegas.hora_inicio',
            'bodegas.telefono',
            'bodegas.direccion',
            'bodegas.updated_at',
            'bodegas.created_at',
            'bodegas.estado_id',
            'bodegas.nombre',
            'estados.nombre as estadoNombre',
            'tipo_bodegas.nombre as tipoBodega',
            'municipios.nombre as nombreMUnicipio'
        )->leftjoin('municipios', 'municipios.id', 'bodegas.municipio_id')
            ->leftjoin('tipo_bodegas', 'tipo_bodegas.id', 'bodegas.tipo_bodega_id')
            ->leftjoin('estados', 'estados.id', 'bodegas.estado_id')->with('user')->where('bodegas.estado_id', 1)->get();
    }

    public function actualizarEstado($data, $id)
    {
        $bodega = $this->bodegaModel::find($id);
        return $bodega->update([
            'estado_id' => $data['estado_id'],
        ]);
    }

    public function agregarPersonal($data)
    {
        $bodega = $this->bodegaModel::find($data['bodega_id']);
        // Filtrar usuarios ya asociados para evitar errores
        $bodega->user()->attach($data['usuarios']);
    }

    public function listarBodegasUsuario()
    {
        return $this->bodegaModel::whereHas('user', function ($query) {
            $query->where('user_id', Auth::id());
        })->with(['user' => function ($query) {
            $query->with('operador');
        }])->get();
    }

    /**
     * Lista las bodegas que el usuario tenga asociadas pero si llega entidad 3 muestra solo aquellas que tenga ferrocarriles en true
     *
     * @param  mixed $entidad
     * @return void
     */
    public function listarBodegasUsuarioPorEntidad(int $entidad)
    {
        return $this->bodegaModel::whereHas('user', function ($query) {
            $query->where('user_id', Auth::id());
        })
        ->when($entidad == 3, function ($query) {
            $query->where('ferrocarriles', true);
        })
        ->with(['user' => function ($query) {
            $query->with('operador');
        }])
        ->get();
    }
    public function listarPorEstado($estado_id)
    {
        return $this->bodegaModel::where('estado_id', $estado_id)->get();
    }

    /**
     * Listar el historico de ordenes dispensadas
     * @param array $request
     * @author Serna
     */
    public function HistoricoOrdenesDispensadas(array $request)
    {
        return $this->ordenModel::with([
            'articulos:id,orden_id,codesumi_id',
            'consulta:id,afiliado_id',
            'consulta.afiliado:id,primer_nombre,segundo_nombre,primer_apellido,segundo_apellido,numero_documento,ips_id',
            'consulta.afiliado.ips:id,nombre',
            'articulos.movimientos:orden_articulo_id,bodega_origen_id,user_id,id,created_at',
            'articulos.movimientos.bodegaOrigen:id,nombre',
            'articulos.movimientos.user:id',
            'articulos.movimientos.user.operador:user_id,nombre,apellido',
        ])

            ->where('ordenes.tipo_orden_id', 1)
            ->whereHas('articulos.movimientos', function ($q2) {
                    $fechaLimite = now()->subMonths(6)->startOfDay();
                    $q2->where('created_at', '>=', $fechaLimite);
                })

            ->whereHas('articulos', function ($query) {
                $query->whereIn('estado_id',  [18, 34]);
            })
            ->when(isset($request['orden_id']), function ($query) use ($request) {
                return $query->where('ordenes.id', $request['orden_id']);
            })
            ->when(isset($request['documento_afiliado']), function ($query) use ($request) {
                return $query->whereHas('consulta.afiliado', function ($q) use ($request) {
                    $q->where('numero_documento', $request['documento_afiliado']);
                });
            })
            ->when(isset($request['ips_id']), function ($query) use ($request) {
                return $query->whereHas('consulta.afiliado', function ($q) use ($request) {
                    $q->where('ips_id', $request['ips_id']);
                });
            })
            ->when(isset($request['nombre_afiliado']), function ($query) use ($request) {
                $nombre = '%' . $request['nombre_afiliado'] . '%';
                return $query->whereHas(
                    'consulta.afiliado',
                    fn($q) =>
                    $q->whereRaw("CONCAT(primer_nombre, ' ', segundo_nombre, ' ', primer_apellido, ' ', segundo_apellido) ILIKE ?", [$nombre])
                );
            })
            ->when(isset($request['bodega_id']), function ($query) use ($request) {
                return $query->whereHas('articulos.movimientos', function ($query) use ($request) {
                    $query->where('bodega_origen_id', $request['bodega_id']);
                });
            })
            ->when(isset($request['fecha_inicio']) && isset($request['fecha_final']), function ($query) use ($request) {
                $seisMesesAtras = now()->subMonths(6)->startOfDay();

                return $query->whereHas('articulos.movimientos', function ($q2) use ($request, $seisMesesAtras) {
                        $fechaInicio = max($seisMesesAtras, Carbon::parse($request['fecha_inicio']));
                        $fechaFinal = Carbon::parse($request['fecha_final'])->endOfDay();

                        $q2->whereBetween('created_at', [$fechaInicio, $fechaFinal]);
                    });
                })
          
            

            ->when(isset($request['user_dispensa_id']), function ($query) use ($request) {
                return $query->whereHas('articulos.movimientos', function ($query) use ($request) {
                    $query->where('user_id', $request['user_dispensa_id']);
                });
            })

            ->orderBy('ordenes.id', 'desc')
            ->paginate($request['cantidad']);
    }

    /**
     * HistoricoOrdenArticulosDispensados
     * Listar el historico de orden articulos dispensados por cada orden_id
     * @param  mixed $orden_id
     * @return void
     */
    public function HistoricoOrdenArticulosDispensados(int $orden_id)
    {
        return OrdenArticulo::where('orden_id', $orden_id)
            ->with([
                'estado:id,nombre',
            ])
            ->whereIn('estado_id', [18, 34])
            ->get();
    }

    /**
     * historicoMovimientosPorOrdenArticulo
     * Listar el historico de movimientos por cada orden_articulo_id
     * @param  mixed $orden_articulo_id
     * @return void
     */
    public function historicoMovimientosPorOrdenArticulo(int $orden_articulo_id)
    {
        return Movimiento::where('orden_articulo_id', $orden_articulo_id)
            ->with(['detalleMovimientos.lote:id,codigo', 'bodegaOrigen:id,nombre', 'user:id', 'user.operador:user_id,nombre,apellido'])
            ->get();
    }

    /**
     * ContadorHistoricoOrdenes
     * Contar el historico de ordenes totales tanto como por todos los filtros
     * @param  mixed $request
     * @return void
     */
    public function ContadorHistoricoOrdenes(array $request)
    {
          // Se filtran las órdenes con tipo_orden_id = 1 y que tengan artículos en los estados 18 o 34
          $ordenes = $this->ordenModel->where('ordenes.tipo_orden_id', 1)
          ->whereHas('articulos', function ($query) {
              $query->whereIn('estado_id', [18, 34]);
          })
          ->whereHas('articulos.movimientos', function ($q2) {
                  $fechaLimite = now()->subMonths(6)->startOfDay();
                  $q2->where('created_at', '>=', $fechaLimite);
              });

      $totalOrdenes = $ordenes->count();

      // Aplicar filtros de fecha si están definidos en la petición
      if (isset($request['fecha_inicio']) && isset($request['fecha_final'])) {
          $seisMesesAtras = now()->subMonths(6)->startOfDay();

          $ordenes = $ordenes->whereHas('articulos.movimientos', function ($q2) use ($request, $seisMesesAtras) {
                  $fechaInicio = max($seisMesesAtras, Carbon::parse($request['fecha_inicio']));
                  $fechaFinal = Carbon::parse($request['fecha_final'])->endOfDay();
                  $q2->whereBetween('created_at', [$fechaInicio, $fechaFinal]);
              });
      }

        //Se realizan los filtros adicionales por cada una de las consultas, se usa el clone para crear una copia de la consulta original
        $ordenesPorDocumento = isset($request['documento_afiliado'])
            ? (clone $ordenes)->whereHas('consulta.afiliado', fn($q) =>
                $q->where('numero_documento', $request['documento_afiliado'])
            )->count() : 0;

        $ordenesPorIps = isset($request['ips_id'])
            ? (clone $ordenes)->whereHas('consulta.afiliado', fn($q) =>
                $q->where('ips_id', $request['ips_id'])
            )->count()
            : 0;

        $ordenesPorNombreAfiliado = isset($request['nombre_afiliado'])
            ? (clone $ordenes)->whereHas('consulta.afiliado', function ($q) use ($request) {
                $nombre = '%' . $request['nombre_afiliado'] . '%';
                $q->whereRaw("CONCAT(primer_nombre, ' ', segundo_nombre, ' ', primer_apellido, ' ', segundo_apellido) ILIKE ?", $nombre);
            })->count()
            : 0;

        $ordenesPorBodega = isset($request['bodega_id'])
            ? (clone $ordenes)->whereHas('articulos.movimientos', fn($q) =>
                $q->where('bodega_origen_id', $request['bodega_id'])
            )->count()
            : 0;

         $ordenesPorUsuario = isset($request['user_dispensa_id'])
            ? (clone $ordenes)->whereHas('articulos.movimientos', fn($q) =>
                $q->where('user_id', $request['user_dispensa_id'])
            )->count()
            : 0;

        return [
            'ordenes_totales' => $totalOrdenes,
            'ordenes_por_documento' => $ordenesPorDocumento,
            'ordenes_por_ips' => $ordenesPorIps,
            'ordenes_por_nombre_afiliado' => $ordenesPorNombreAfiliado,
            'ordenes_por_bodega' => $ordenesPorBodega,
            'ordenes_por_usuario' => $ordenesPorUsuario
        ];
    }

    public function formatoSolicitudes()
    {
        $solicitudBodega = $this->solicitudBodega->where('id', $request)->first();

        $articulos = $this->detalleSolicitudBodega->select([
            'detalle_solicitud_bodegas.cantidad_inicial',
            'detalle_solicitud_bodegas.cantidad_aprobada',
            'detalle_solicitud_bodegas.estado_id',
            'detalle_solicitud_bodegas.precio_unidad_aprobado as precio_unidad',
            DB::raw('null as unidad_compra'),
            'detalle_solicitud_bodegas.medicamento_id'
        ])
            ->where('detalle_solicitud_bodegas.solicitud_bodega_id', $request)
            ->get();

        $prestador = null;
        if ($solicitudBodega->rep_id) {
            $prestador = $this->rep->select([
                'prestadores.nombre_prestador',
                'prestadores.nit',
                'prestadores.direccion',
                'prestadores.telefono1',
                'municipios.nombre as municipio'
            ])
                ->join('prestadores', 'prestadores.id', 'reps.prestador_id')
                ->join('municipios', 'municipios.id', 'prestadores.municipio_id')
                ->where('reps.id', $solicitudBodega->rep_id)
                ->first();
        }
        return (object)[
            'solicitudBodega' => $solicitudBodega,
            'articulos' => $articulos,
            'prestador' => $prestador,
        ];
    }
}
