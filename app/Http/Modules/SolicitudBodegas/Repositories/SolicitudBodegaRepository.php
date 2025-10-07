<?php

namespace App\Http\Modules\SolicitudBodegas\Repositories;

use Illuminate\Support\Facades\DB;
use App\Http\Modules\Bases\RepositoryBase;
use App\Http\Modules\SolicitudBodegas\Models\SolicitudBodega;
use App\Http\Modules\DetalleSolicitudBodegas\Models\DetalleSolicitudBodega;
use App\Http\Modules\Medicamentos\Models\BodegaMedicamento;
use App\Http\Modules\Medicamentos\Models\Lote;
use App\Http\Modules\Reps\Models\Rep;

class SolicitudBodegaRepository extends RepositoryBase
{
    protected $SolicitudBodegaModel;

    public function __construct() {
        $this->SolicitudBodegaModel = new SolicitudBodega();
        parent::__construct($this->SolicitudBodegaModel);
    }

    public function consultarSolicitud($solicitud_id)
    {
        $solicitud = $this->SolicitudBodegaModel->find($solicitud_id);
        $solicitud->update([
            "estado_id" => 4,
            'usuario_aprueba_id' => auth()->user()->id
        ]);
    }

    public function obtnerAjuste($data)
    {
        return  $this->SolicitudBodegaModel::select(
            'detalle_solicitud_bodegas.id as detalle_id',
            'solicitud_bodegas.id',
            'detalle_solicitud_bodegas.descripcion',
            'detalle_solicitud_bodegas.medicamento_id',
            'codesumis.nombre as producto',
            'cums.cum_validacion',
            'detalle_solicitud_bodegas.cantidad_inicial',
            'detalle_solicitud_bodegas.bodega_medicamento_id',
            'detalle_solicitud_bodegas.lote',
            'detalle_solicitud_bodegas.fecha_vencimiento',
            'detalle_solicitud_bodegas.observacion',
            'solicitud_bodegas.created_at'
        )
            ->join('detalle_solicitud_bodegas', 'detalle_solicitud_bodegas.solicitud_bodega_id', 'solicitud_bodegas.id')
            ->join('medicamentos', 'medicamentos.id', 'detalle_solicitud_bodegas.medicamento_id')
            ->leftjoin('cums', 'cums.cum_validacion', 'medicamentos.cum')
            ->join('codesumis', 'codesumis.id', 'medicamentos.codesumi_id')
            ->where('tipo_solicitud_bodega_id', $data['tipo'])
            ->where('bodega_origen_id', $data['bodega'])
            ->where('detalle_solicitud_bodegas.estado_id', $data['estado'])
            ->distinct('detalle_solicitud_bodegas.id')->get();
    }


    public function solicitudCompras($data)
    {

        return $this->SolicitudBodegaModel::select('detalle.numero_factura as detalle_id', 'reps.nombre', 'reps.id as proveedorId', 'detalle.created_at','p.nombre as proveedor')
            // ->selectRaw('(select created_at from detalle_solicitud_bodegas where id = detalle.id LIMIT 1 ) as created_at')
            ->join('detalle_solicitud_bodegas as detalle', 'detalle.solicitud_bodega_id', 'solicitud_bodegas.id')
            ->leftjoin('reps', 'reps.id', 'solicitud_bodegas.rep_id')
            ->leftjoin('proveedores as p','solicitud_bodegas.proveedor_id','p.id')
            ->where('solicitud_bodegas.bodega_origen_id', $data['bodega_id'])
            ->whereIn('detalle.estado_id', [14,17])
            ->whereIn('solicitud_bodegas.tipo_solicitud_bodega_id',[1,9])
            ->whereBetween('detalle.created_at', [$data['fecha_desde'] . ' 00:00:00.000', $data['fecha_hasta'] . ' 23:59:59.999'])
            ->groupBy('detalle.numero_factura', 'reps.nombre', 'reps.id', 'detalle.created_at','p.nombre')
            ->get();
    }

    public function crearDetalleAjusteEntrada($data, $solicitudBodega_id, $bodega_destino_id)
    {
        foreach ($data as $articulo) {



            $bodegaMedicamento = BodegaMedicamento::where('bodega_id', $bodega_destino_id)->where('medicamento_id', $articulo['medicamento_id'])->first();
            $lote = Lote::where('codigo', $articulo['lote'])->where('bodega_medicamento_id', $bodegaMedicamento->id)->first();
            if (!$lote) {
                Lote::create([
                    'codigo' => $articulo['lote'],
                    'cantidad' => 0,
                    'fecha_vencimiento' => $articulo['fecha_vencimiento'],
                    'bodega_medicamento_id' => $bodegaMedicamento->id,
                    'estado_id' => 1
                ]);
            }
            DetalleSolicitudBodega::create([
                'solicitud_bodega_id' => $solicitudBodega_id,
                'medicamento_id' => $articulo['medicamento_id'],
                'cantidad_inicial' => $articulo['cantidad_inicial'],
                'cantidad_aprobada' => null,
                'cantidad_entregada' => null,
                'precio_unidad_aprobado' => null,
                'precio_unidad_entrega' => null,
                'descripcion' => $articulo['descripcion'],
                'lote' => $articulo['lote'],
                'estado_id' => 3,
                'bodega_medicamento_id' => $bodegaMedicamento->id,
                'codesumi_id' => null,
                'fecha_vencimiento' => $articulo['fecha_vencimiento'],
                'numero_factura' => null,
                'observacion' => $articulo['observacion']
            ]);
        }
        return $solicitudBodega_id;
    }

    public function crearDetalleCompra($data, $solicitudBodega_id)
    {

        foreach ($data['articulos'] as $articulo) {
            $articulo["solicitud_bodega_id"] = $solicitudBodega_id;
            $detalle = new DetalleSolicitudBodega($articulo);
            $detalle->estado_id = 3;
            $detalle->save();
        }
        return $solicitudBodega_id;
    }

    public function crearDetalleTraslado($data, $solicitudBodega_id)
    {

        foreach ($data as $articulo) {

            DetalleSolicitudBodega::create([
                'solicitud_bodega_id' => $solicitudBodega_id,
                'medicamento_id' => $articulo['medicamento_id'],
                'cantidad_inicial' => $articulo['cantidad_inicial'],
                'cantidad_aprobada' => null,
                'cantidad_entregada' => null,
                'precio_unidad_aprobado' => null,
                'precio_unidad_entrega' => null,
                'bodega_medicamento_id' => $articulo['articulo']['bodegaMedicamento'],
                'estado_id' => 3,
            ]);
        }
        return $solicitudBodega_id;
    }

    public function listarTraslado($solicitud, $estado, $bodega)
    {
        // return SolicitudBodega::where('tipo_solicitud_bodega_id', $solicitud)->where('bodega_destino_id', $bodega)
        //                     ->where('estado_id', $estado)
        //                     ->with(['usuarioSolicita','usuarioSolicita.operador:id,user_id,nombre',
        //                     'detallesSolicitud','rep:id,nombre,codigo','detallesSolicitud.novedades',
        //                     'detallesSolicitud.lotes','bodegaOrigen:id,nombre','detallesSolicitud.medicamento:id,cum,codesumi_id',
        //                     'detallesSolicitud.medicamento.invima:id,cum_validacion,titular,producto,descripcion_comercial',
        //                     'detallesSolicitud.medicamento.codesumi:id,nombre,codigo'])->get();

        return DetalleSolicitudBodega::with([
            'solicitudBodega.usuarioSolicita',
            'solicitudBodega.usuarioSolicita.operador:id,user_id,nombre',
            'solicitudBodega.rep:id,nombre,codigo',
            'novedades',
            'lotes',
            'solicitudBodega.bodegaOrigen:id,nombre',
            'medicamento:id,cum,codesumi_id',
            'medicamento.invima:id,cum_validacion,titular,producto,descripcion_comercial',
            'medicamento.codesumi:id,nombre,codigo',
            'solicitudBodega.bodegaDestino:id,nombre'
        ])
            ->whereHas('solicitudBodega', function ($query) use ($solicitud, $estado, $bodega) {
                $query->where('tipo_solicitud_bodega_id', $solicitud)
                    ->where('estado_id', $estado)
                    ->where('bodega_destino_id', $bodega);
            })->orderBy('created_at', 'asc')
            ->where('detalle_solicitud_bodegas.estado_id', $estado)
            ->get();
    }

    public function actualizarSolicitud($solicitud_id)
    {
        $solicitud = $this->SolicitudBodegaModel->find($solicitud_id);
        $solicitud->update([
            "estado_id" => 22,
            'usuario_ejecuta_id' => auth()->user()->id
        ]);
    }

    public function rechazarSolicitudTraslado($data)
    {


        DetalleSolicitudBodega::where('solicitud_bodega_id', $data['id'])
            ->update([
                "cantidad_aprobada" => 0,
                "lote" => null,
                "estado_id" => 5,
                "observacion" => $data['descripcion']
            ]);
        SolicitudBodega::find($data['id'])->update([
            "estado_id" => 5,
            'usuario_aprueba_id' => auth()->user()->id
        ]);
    }

    public function listarTrasladoPendiente($solicitud, $estado)
    {
        return DetalleSolicitudBodega::with([
            'solicitudBodega.usuarioSolicita',
            'solicitudBodega.usuarioSolicita.operador:id,user_id,nombre',
            'solicitudBodega.rep:id,nombre,codigo',
            'novedades',
            'lotes',
            'solicitudBodega.bodegaOrigen:id,nombre',
            'medicamento:id,cum,codesumi_id',
            'medicamento.invima:id,cum_validacion,titular,producto,descripcion_comercial',
            'medicamento.codesumi:id,nombre,codigo',
            'solicitudBodega.bodegaDestino:id,nombre'
        ])
            ->whereHas('solicitudBodega', function ($query) use ($solicitud, $estado) {
                $query->where('tipo_solicitud_bodega_id', $solicitud)
                    ->where('estado_id', $estado);
            })->orderBy('created_at', 'asc')
            ->where('detalle_solicitud_bodegas.estado_id', $estado)
            ->get();
    }

    public function formatoSolicitudes($request)
    {
        $solicitudBodega = $this->SolicitudBodegaModel->where('id', $request)->first();

        $articulos = DetalleSolicitudBodega::select([
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
            $prestador = Rep::select([
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

     /**
	 * busca la solicitud por id
	 * @param int $solicitud_id
     * @param int $estado_id
	 * @author Jdss
	 */
    public function buscarSolicitud ($id) {
        return $this->SolicitudBodegaModel->where('id', $id)->first();
    }

     /**
	 * Actualiza la solicitud
	 * @param int $solicitud_id
     * @param int $estado_id
	 * @author Jdss
	 */
    public function actualizarSolicitudes(int $id, array $data){
        return $this->SolicitudBodegaModel->where('id',$id)->update($data);
    }
}
