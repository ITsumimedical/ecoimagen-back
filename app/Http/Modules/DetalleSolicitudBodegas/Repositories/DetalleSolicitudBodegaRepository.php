<?php

namespace App\Http\Modules\DetalleSolicitudBodegas\Repositories;

use App\Http\Modules\Bases\RepositoryBase;
use App\Http\Modules\DetalleSolicitudBodegas\Models\DetalleSolicitudBodega;

class DetalleSolicitudBodegaRepository extends RepositoryBase
{

    protected $detalleSolicitudModel;

    public function __construct()
    {
        $this->detalleSolicitudModel = new DetalleSolicitudBodega();
        parent::__construct($this->detalleSolicitudModel);
    }

    public function consultarDetalle($detalle_id, $total)
    {
        $detalle = $this->detalleSolicitudModel->find($detalle_id);
        $detalle->update([
            "estado_id" => 4,
            'cantidad_aprobada' => $total
        ]);
        return $detalle;
    }

    public function actualizarDetalleTraslado($detalle_id, $total)
    {
        $detalle = $this->detalleSolicitudModel->find($detalle_id);
        $detalle->update([
            "estado_id" => 22,
            'cantidad_entregada' => $total
        ]);
        return $detalle;
    }

    public function actaRecepcion($request)
    {
        $ordenesCompra = $this->detalleSolicitudModel->select(
            'detalle_solicitud_bodegas.updated_at as FECHA DE RECEPCION',
            'detalle_solicitud_bodegas.numero_factura as NUMERO DE FACTURA',
            'reps.nombre as PROVEEDOR',
            'detalle_solicitud_bodegas.updated_at as FECHA FACTURA',
            'codesumis.codigo as CODIGO MEDICAMENTO',
            'codesumis.nombre as DESCRIPCION',
            'cums.producto as DESCRIPCION COMERCIAL',
            'cums.titular as LABORATORIO',
            'cums.registro_sanitario as REGISTRO SANITARIO',
            'cums.expediente as NUMERO EXPEDIENTE',
            'detalle_solicitud_bodegas.solicitud_bodega_id as CONSECUTIVO FACTURA',
            'bodegas.nombre as ALMACEN',
            'operadores.nombre as INGRESO LA FACTURA',
            'operadores.user_id as user_id',
            'operadores.apellido as APELLIDO',
            'cums.fecha_vencimiento as FECHA DE VENCIMIENTO REGISTRO SANITARIO',
            'cums.descripcion_comercial as PRESENTACION',
            'cums.forma_farmaceutica as FORMA FARMACEUTICA',
            'lotes.codigo as LOTE',
            'detalle_solicitud_lotes.cantidad as CANTIDAD',
            'lotes.fecha_vencimiento as FECHA VENCIMIENTO',
            'detalle_solicitud_lotes.temperatura',
            'p.nombre as proveedor2',
            'detalle_solicitud_bodegas.descripcion as observaciones'
        )
            ->join('solicitud_bodegas', 'detalle_solicitud_bodegas.solicitud_bodega_id', 'solicitud_bodegas.id')
            ->leftjoin('reps', 'reps.id', 'solicitud_bodegas.rep_id')
            ->join('medicamentos', 'medicamentos.id', 'detalle_solicitud_bodegas.medicamento_id')
            ->join('codesumis', 'codesumis.id', 'medicamentos.codesumi_id')
            ->join('cums', 'cums.cum_validacion', 'medicamentos.cum')
            ->join('bodegas', 'bodegas.id', 'solicitud_bodegas.bodega_origen_id')
            ->leftjoin('users', 'users.id', 'solicitud_bodegas.usuario_solicita_id')
            ->leftjoin('operadores', 'operadores.user_id', 'users.id')
            ->leftjoin('detalle_solicitud_lotes', 'detalle_solicitud_lotes.detalle_solicitud_bodega_id', 'detalle_solicitud_bodegas.id')
            ->leftjoin('lotes', 'lotes.id', 'detalle_solicitud_lotes.lote_id')
            ->leftjoin('proveedores as p','solicitud_bodegas.proveedor_id','p.id')
            // ->where('solicitud_bodegas.id',$data['numeroFactura'])
            ->where('detalle_solicitud_bodegas.numero_factura', $request['numeroFactura'])
            // ->where('solicitud_bodegas.rep_id',$data['proveedor_id'])
            ->whereIn('detalle_solicitud_bodegas.estado_id', [17,14])
            ->whereIn('solicitud_bodegas.tipo_solicitud_bodega_id', [1,9])
            ->distinct('detalle_solicitud_bodegas.id')
            ->get();
        return $ordenesCompra;
    }

    /**
	 * obtiene el detalle por solicitud
	 * @param int $solicitud_bodega_id
	 * @return $detalleSolicitudModel
	 * @author Jdss
	 */
    public function buscarDetalleSolicitud (int $solicitud_bodega_id) {
        $datos = DetalleSolicitudBodega::where('solicitud_bodega_id', $solicitud_bodega_id)->count();
        return $datos;
    }

     /**
	 * actualiza el detalle
	 * @param int $id
     * @param array $data
	 * @return $detalleSolicitudModel
	 * @throws \Throwable
	 * @author Jdss
	 */
    public function actualizarDetalle (int $id, array $data) {
        return $this->detalleSolicitudModel->where('id', $id)->update($data);
    }

     /**
	 * busca segun el estado del detalle y la solicitud
	 * @param int $solicitud_id
     * @param int $estado_id
	 * @return $detalleSolicitudModel
	 * @throws \Throwable
	 * @author Jdss
	 */
    public function buscarPorEstado (int $solicitud_id, int $estado_id) {
        $datos = DetalleSolicitudBodega::where('solicitud_bodega_id', $solicitud_id)
        ->where('estado_id',$estado_id)
        ->count();
        return $datos;
    }
}
