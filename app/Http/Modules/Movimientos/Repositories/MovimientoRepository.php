<?php

namespace App\Http\Modules\Movimientos\Repositories;

use App\Http\Modules\Bases\RepositoryBase;
use App\Http\Modules\Movimientos\Models\Movimiento;

class MovimientoRepository extends RepositoryBase
{

    public function __construct(protected Movimiento $movimientoModel) {
        parent::__construct($this->movimientoModel);
    }

    public function guardarMovimientoTraslado($data,$tipo){

        return $this->movimientoModel->create([
            'tipo_movimiento_id' => $tipo,
            'bodega_origen_id' => $data['bodega_origen_id'],
            'bodega_destino_id'=> $data['bodega_destino_id'],
            'solicitud_bodega_id' => $data['id'],
            'user_id'=>auth()->user()->id
        ]);
    }


    public function verificarExistenciaFactura($factura)
    {
        return Movimiento::where('codigo_factura', 'ILIKE', "%{$factura}%")
            ->with([
                'solicitudBodega:id',
                'solicitudBodega.detallesSolicitud' => function ($query) {
                    $query->where('estado_id', 17)
                          ->select('medicamento_id', 'solicitud_bodega_id', 'id', 'numero_factura', 'lote', 'cantidad_inicial', 'cantidad_aprobada', 'cantidad_entregada', 'estado_id');
                },
                'solicitudBodega.detallesSolicitud.estado:id,nombre',
                'solicitudBodega.detallesSolicitud.medicamento.codesumi:id,nombre,codigo'
            ])->distinct()->get();
    }

    public function actaRecepcionConsignacion($idMovimiento)
    {
        return Movimiento::select([
            'movimientos.created_at as FECHA DE RECEPCION',
            'movimientos.codigo_factura as NUMERO DE FACTURA',
            'p.nombre as PROVEEDOR',
            'sb.created_at as FECHA FACTURA',
            'c.nombre as DESCRIPCION',
            'cums.producto as DESCRIPCION COMERCIAL',
            'cums.titular as LABORATORIO',
            'cums.registro_sanitario as REGISTRO SANITARIO',
            'dsl.temperatura as temperatura',
            'cums.descripcion_comercial as PRESENTACION',
            'cums.forma_farmaceutica as FORMA FARMACEUTICA',
            'l.codigo as LOTE',
            'l.fecha_vencimiento as FECHA VENCIMIENTO',
            'dsl.cantidad as CANTIDAD',
            'cums.expediente as NUMERO EXPEDIENTE',
            'b.nombre as ALMACEN',
            'dsb.descripcion as observaciones',
            'movimientos.user_id'
        ])->join('detalle_movimientos as dm','movimientos.id','dm.movimiento_id')
            ->join('solicitud_bodegas as sb','movimientos.solicitud_bodega_id','sb.id')
            ->join('lotes as l','dm.lote_id','l.id')
            ->join('proveedores as p','sb.proveedor_id','p.id')
            ->join('bodega_medicamentos as bm','bm.id','l.bodega_medicamento_id')
            ->join('medicamentos as m','bm.medicamento_id','m.id')
            ->join('codesumis as c','m.codesumi_id','c.id')
            ->join('cums','m.cum','cums.cum_validacion')
            ->join('detalle_solicitud_bodegas as dsb','sb.id','dsb.solicitud_bodega_id')
            ->join('detalle_solicitud_lotes as dsl', function ($join){
                $join->on('dsl.lote_id','l.id');
                $join->on('dsl.detalle_solicitud_bodega_id','dsb.id');
            })
            ->join('bodegas as b','sb.bodega_origen_id','b.id')
            ->where('movimientos.id',$idMovimiento)
            ->distinct()
            ->get();
    }

}
