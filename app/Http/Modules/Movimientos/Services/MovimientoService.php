<?php

namespace App\Http\Modules\Movimientos\Services;

use App\Formats\ActaRecepcion;
use App\Http\Modules\DetalleSolicitudBodegas\Repositories\DetalleSolicitudBodegaRepository;
use App\Http\Modules\DetalleSolicitudLote\Models\DetalleSolicitudLote;
use App\Http\Modules\DetalleSolicitudLote\Repositories\DetallesolicitudLoteRepository;
use App\Http\Modules\HistoricoPrecioProveedorMedicamento\Repositories\HistoricoPrecioProveedorMedicamentoRepository;
use App\Http\Modules\Medicamentos\Models\BodegaMedicamento;
use App\Http\Modules\Medicamentos\Models\Lote;
use App\Http\Modules\Medicamentos\Repositories\BodegaMedicamentoRepository;
use App\Http\Modules\Medicamentos\Repositories\LoteRepository;
use App\Http\Modules\Medicamentos\Repositories\PrecioRepository;
use App\Http\Modules\Movimientos\Models\Movimiento;
use App\Http\Modules\Movimientos\Repositories\DetalleMovimientoRepository;
use App\Http\Modules\Movimientos\Repositories\MovimientoRepository;
use App\Http\Modules\SolicitudBodegas\Repositories\NovedadSolicitudesRepository;
use App\Http\Modules\SolicitudBodegas\Repositories\SolicitudBodegaRepository;
use App\Http\Modules\SolicitudBodegas\Services\SolicitudBodegaService;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class MovimientoService
{
    public function __construct(protected SolicitudBodegaRepository $solicitudBodegaRepository,
                                protected DetalleSolicitudBodegaRepository $detalleSolicitudBodegaRepository,
                                protected MovimientoRepository $movimientoRepository,
                                protected BodegaMedicamentoRepository $bodegaMedicamentoRepository,
                                protected LoteRepository $loteRepository,
                                protected DetalleMovimientoRepository $detalleMovimientoRepository,
                                protected DetallesolicitudLoteRepository $detallesolicitudLoteRepository,
                                protected NovedadSolicitudesRepository $novedadSolicitudesRepository,
                                protected PrecioRepository $precioRepository,
                                protected HistoricoPrecioProveedorMedicamentoRepository $historicoPrecioProveedorMedicamentoRepository,
                                protected SolicitudBodegaService $solicitudBodegaService)
    {

    }
    public function listarDispensacion($ordenArticuloId)
    {
        $consulta = Movimiento::where('orden_articulo_id', $ordenArticuloId)->with(['user.operador','bodegaOrigen']);

        return $consulta->get();
    }

    public function movimientoConsignacion($request){
        DB::beginTransaction();
        try{
            $datosSolicitud = [
                'bodega_origen_id'=> $request['bodega_origen_id'],
                'bodega_destino_id' => $request['bodega_origen_id'],
                'usuario_solicita_id' => Auth::id(),
                'estado_id' => 17,
                'tipo_solicitud_bodega_id' => 9,
                'proveedor_id' => $request['proveedor_id'],
            ];
            $solicitud = $this->solicitudBodegaRepository->crear($datosSolicitud);
            $datosMovimientos = [
                'tipo_movimiento_id' => 18,
                'proveedor_id' => $request['proveedor_id'],
                'bodega_origen_id'=> $request['bodega_origen_id'],
                'bodega_destino_id' => $request['bodega_origen_id'],
                'solicitud_bodega_id' => $solicitud->id,
                'codigo_factura' => $request['ordenDespacho'],
                'user_id' => Auth::id(),
            ];
            $movimiento = $this->movimientoRepository->crear($datosMovimientos);
            foreach ($request['detalles'] as $detalle){
                foreach ($detalle['lotes'] as $lote){
                    $datosDetalle = [
                        'solicitud_bodega_id' => $solicitud->id,
                        'medicamento_id' => $detalle['articulo']['id'],
                        'cantidad_inicial' => $lote['cantidad'],
                        'cantidad_aprobada' => $lote['cantidad'],
                        'cantidad_entregada' => $lote['cantidad'],
                        'descripcion' => 'ingreso por consignacion',
                        'fecha_vencimiento' => $lote['fecha_vencimiento'],
                        'lote' => $lote['nombre'],
                        'estado_id' => 17,
                        'numero_factura' => $request['ordenDespacho']
                    ];
                    $detalleSolicitudBodega = $this->detalleSolicitudBodegaRepository->crear($datosDetalle);
                    $bodegaMedicamento = BodegaMedicamento::where('medicamento_id',$detalle['articulo']['id'])->where('bodega_id',$request['bodega_origen_id'])->first();
                    if(!$bodegaMedicamento){
                        $datosBodegaMedicamentos = [
                            'medicamento_id' => $detalle['articulo']['id'],
                            'bodega_id' => $request['bodega_origen_id'],
                            'cantidad_total' => 0
                        ];
                        $bodegaMedicamento = $this->bodegaMedicamentoRepository->crear($datosBodegaMedicamentos);
                    }
                    $bodegaMedicamento->cantidad_total += intval($lote['cantidad']);
                    $bodegaMedicamento->save();
                    $loteRegistrado = Lote::where('bodega_medicamento_id',$bodegaMedicamento->id)->where('codigo',$lote['nombre'])->first();
                    if(!$loteRegistrado){
                        $datosLoteMedicamentos = [
                            'codigo' => $lote['nombre'],
                            'fecha_vencimiento' => $lote['fecha_vencimiento'],
                            'bodega_medicamento_id' => $bodegaMedicamento->id,
                            'cantidad' => 0,
                            'estado_id' => 1
                        ];
                        $loteRegistrado = $this->loteRepository->crear($datosLoteMedicamentos);
                    }
                    $cantidadAnterior = $loteRegistrado->cantidad;
                    $loteRegistrado->cantidad += intval($lote['cantidad']);
                    $loteRegistrado->save();
                    $datosDetalleMovimientos = [
                        'movimiento_id' => $movimiento->id,
                        'bodega_medicamento_id' => $bodegaMedicamento->id,
                        'cantidad_anterior' => $cantidadAnterior,
                        'cantidad_solicitada' => $lote['cantidad'],
                        'cantidad_final' => $loteRegistrado->cantidad,
                        'precio_unidad' => null,
                        'valor_total' => null,
                        'valor_promedio' => null,
                        'lote_id' => $loteRegistrado->id,
                    ];
                    $this->detalleMovimientoRepository->crear($datosDetalleMovimientos);
                    $datosSolicitudLote = [
                        'cantidad' => intval($lote['cantidad']),
                        'lote_id' => $loteRegistrado->id,
                        'detalle_solicitud_bodega_id' => $detalleSolicitudBodega->id,
                        'temperatura' => $detalle['temperatura'],
                    ];
                    $this->detallesolicitudLoteRepository->crear($datosSolicitudLote);
                }
            }
            DB::commit();
            $actaRecepcion = $this->movimientoRepository->actaRecepcionConsignacion($movimiento->id);
            $pdf = new ActaRecepcion('p', 'mm', 'A3');
            return $pdf->generar($actaRecepcion);
        }catch (\Exception $e){
            DB::rollback();
            trigger_error($e->getMessage());
        }
    }

    public function guardarFirmaRecibe(int $movimiento_id, $request)
    {
        return Movimiento::where('id', $movimiento_id)->update([
            'firma_persona_recibe' => $request['firma']
        ]);
    }

    public function guardar($request,$tipo){
        DB::beginTransaction();
        try {
            $solicitud = $this->solicitudBodegaRepository->buscarSolicitud($request['solicitud'][0]['solicitud_bodega_id']);
            $crearMovimiento = $this->movimientoRepository->crear([
                'tipo_movimiento_id' => 3,
                'codigo_factura' => $request['factura'],
                'user_id' => auth()->user()->id,
                'bodega_origen_id' => $solicitud->bodega_origen_id,
                'solicitud_bodega_id' => $solicitud->id,
            ]);
            foreach ($request['solicitud'] as $detalleSolicitud)
            {
                foreach ($detalleSolicitud['novedades'] as $novedad)
                {
                    if(!$novedad['devolucion']){
                        $finalizar = false;
                        $cantidadRecibidad = isset($detalleSolicitud['cantidad_aprobada']) ? intval($detalleSolicitud['cantidad_aprobada']) : 0;
                        $medicamento_id = $detalleSolicitud['medicamento_id'];
                        if ($novedad['tipoNovedad']) {
                            $crearNovedad = $this->novedadSolicitudesRepository->crear([
                                'tipo_novedad_solicitud_id' => $novedad['tipoNovedad']['id'],
                                'medicamento_id' => $novedad['nuevoMedicamento'],
                                'detalle_solicitud_bodega_id' => $detalleSolicitud['id'],
                                'precio' => $novedad['precio'],
                                'cantidad' => $novedad['cantidad'],
                                'devolucion' => $novedad['devolucion'],
                                'observacion' => $novedad['observacion'],
                            ]);

                                        if ($novedad['tipoNovedad']['nombre'] === 'Sobrante' || $novedad['tipoNovedad']['nombre'] === 'Faltante' || $novedad['tipoNovedad']['nombre'] === 'Averias') {
                                            $cantidadRecibidad = $novedad['cantidad'];
                                            $finalizar = true;
                                        }
                                        if ($novedad['tipoNovedad']['nombre'] === 'Producto No Solicitado') {
                                            $medicamento_id = $novedad['nuevoMedicamento'];
                                        }
                                        if ($novedad['tipoNovedad']['nombre'] === 'Nuevo precio' || $novedad['tipoNovedad']['nombre'] === 'Producto no solicitado') {
                                            $datosPrecio = [];
                                            $datosPrecio['medicamento_id'] = $medicamento_id;
                                            $datosPrecio['rep_id'] = $solicitud->rep_id;
                                            $datosPrecio['precio_unidad'] = abs($novedad['precio']);
                                            $actualozarPrecio = $this->precioRepository->crearActualizar($datosPrecio);
                                            if (!$actualozarPrecio) {
                                                throw new \Exception('Ocurrio un error al crear el precio', 404);
                                            }
                                            $datosPrecio['solicitud_bodega_id'] =  $solicitud->id;
                                            $crearHistorico = $this->historicoPrecioProveedorMedicamentoRepository->crear($datosPrecio);
                                            if (!$crearHistorico) {
                                                throw new \Exception('Ocurrio un error al crear el historico', 404);
                                            }
                                        }
                        }
                        if (intval($cantidadRecibidad) > 0) {
                             $BodegaArticulo = $this->bodegaMedicamentoRepository->buscarBodega($solicitud->bodega_origen_id,$medicamento_id);
                             if (!$BodegaArticulo) {
                                 $datosBodegaMedicamentos = [];
                                 $datosBodegaMedicamentos['bodega_id'] =  $solicitud->bodega_origen_id;
                                 $datosBodegaMedicamentos['medicamento_id'] = $medicamento_id;
                                 $datosBodegaMedicamentos['cantidad_total'] = 0;
                                 $crearBodega = $this->bodegaMedicamentoRepository->crear($datosBodegaMedicamentos);
                                 if(!$crearBodega){
                                    throw new \Exception('Ocurrio un error al crear la asociación de la bodega con el medicamento', 404);
                                 }
                            }
                        }
                    } else{
                        $crearNovedad = $this->novedadSolicitudesRepository->crear([
                            'tipo_novedad_solicitud_id' => $novedad['tipoNovedad']['id'],
                            'medicamento_id' => $novedad['nuevoMedicamento'],
                            'detalle_solicitud_bodega_id' => $detalleSolicitud['id'],
                            'precio' => $novedad['precio'],
                            'cantidad' => $novedad['cantidad'],
                            'devolucion' => $novedad['devolucion'],
                            'observacion' => $novedad['observacion'],
                        ]);
                        if(!$crearNovedad){
                            throw new \Exception('Ocurrio un error al crear la novedad', 404);
                        }
                    }
                }

                $medicamento_id = $detalleSolicitud['medicamento_id'];
                $BodegaArticulo = $this->bodegaMedicamentoRepository->buscarBodega($solicitud->bodega_origen_id,$medicamento_id);
                if (!$BodegaArticulo) {
                    $BodegaArticulo = $this->bodegaMedicamentoRepository->crear([
                        'bodega_id' => $solicitud->bodega_origen_id,
                        'medicamento_id' => $medicamento_id,
                        'cantidad_total' => 0,
                    ]);
                    if(!$BodegaArticulo){
                       throw new \Exception('Ocurrio un error al crear la asociación de la bodega con el medicamento', 404);
                    }
               }

               foreach ($detalleSolicitud['lotes'] as $lotes) {
                $cantidadRecibidad = $lotes['cantidad'];
                $lote = $this->loteRepository->buscarLoteExacto($lotes,$BodegaArticulo->id);
                if(!$lote){
                    $cantidad = abs(intval($BodegaArticulo->cantidad_total) + intval($lotes['cantidad']));
                    $actualizarBodegaMedicamento = $this->bodegaMedicamentoRepository->actualizarBodegaMedicamento($BodegaArticulo->id,['cantidad_total' => $cantidad]);
                    if(!$actualizarBodegaMedicamento){
                        throw new \Exception('Ocurrio un error al actualizar bodega con el medicamento', 422);
                     }
                     $nuevoLote = $this->loteRepository->crear([
                        'codigo' => $lotes['lote'],
                        'fecha_vencimiento' => $lotes['fecha'],
                        'cantidad' => $lotes['cantidad'],
                        'bodega_medicamento_id' => $BodegaArticulo->id,
                        'estado_id' => 1,
                    ]);

                    if (!$nuevoLote) {
                        throw new \Exception('Ocurrió un error al crear el lote', 422);
                    }

                    $detalleLote = $this->detallesolicitudLoteRepository->crear([
                        'cantidad' => $nuevoLote['cantidad'],
                        'lote_id' => $nuevoLote->id,
                        'detalle_solicitud_bodega_id' => $detalleSolicitud['id'],
                        'temperatura' => floatval($lotes['temperatura']),
                        'observaciones' => $lotes['observaciones']
                    ]);

                    if (!$detalleLote) {
                        throw new \Exception('Ocurrió un error al crear el detalle del lote', 422);
                    }
                    $detalleMovimiento = $this->detalleMovimientoRepository->crear([
                        'lote_id' => $nuevoLote->id,
                        'movimiento_id' => $crearMovimiento->id,
                        'cantidad_anterior' => 0,
                        'cantidad_solicitada' => $cantidadRecibidad,
                        'cantidad_final' => $cantidadRecibidad,
                        'precio_unidad' => intval($detalleSolicitud['precio_unidad_aprobado']),
                        'valor_total' => intval($detalleSolicitud['precio_unidad_aprobado']) * intval($cantidadRecibidad),
                        'valor_promedio' => 0,
                        'bodega_medicamento_id' => $BodegaArticulo->id,
                    ]);

                    if (!$detalleMovimiento) {
                        throw new \Exception('Ocurrió un error al crear el detalle del movimiento', 422);
                    }

                    $actualizarDetalle = $this->detalleSolicitudBodegaRepository->actualizarDetalle($detalleSolicitud["id"],[
                        'estado_id' => ((intval($detalleSolicitud["cantidad_aprobada"]) - intval($lotes['cantidad']) === 0) ? 17 : 14),
                        'bodega_medicamento_id' => $BodegaArticulo->id,
                        'lote' => $lotes["lote"],
                        'cantidad_entregada' =>  intval($lotes['cantidad']),
                        'numero_factura' => $request['factura']
                    ]);

                    if (!$actualizarDetalle) {
                        throw new \Exception('Ocurrió un error al actualizar el detalle de la solicitud', 422);
                    }
                } else {
                    $bodegaMedicamento = $this->bodegaMedicamentoRepository->buscarBodegaId($lote["bodega_medicamento_id"]);
                    $actualizarBodegaMedicamento = $this->bodegaMedicamentoRepository->actualizarBodegaMedicamento($bodegaMedicamento['id'],['cantidad_total' => abs(intval($bodegaMedicamento['cantidad_total']) + intval($cantidadRecibidad))]);
                    $actualizarLote = $this->loteRepository->actualizarLote($lote["id"],[
                    'fecha_vencimiento' => $lotes["fecha"],'cantidad' => abs(intval($lote["cantidad"]) + intval($cantidadRecibidad))]);
                    $detalleLote = $this->detallesolicitudLoteRepository->crear([
                        'cantidad' => $cantidadRecibidad,
                        'lote_id' => $lote['id'],
                        'detalle_solicitud_bodega_id' => $detalleSolicitud['id'],
                        'temperatura' => floatval($lotes['temperatura']),
                        'observaciones' => $lotes['observaciones']
                    ]);

                    if (!$detalleLote) {
                        throw new \Exception('Ocurrió un error al crear el detalle del lote', 422);
                    }

                    $detalleMovimiento = $this->detalleMovimientoRepository->crear([
                        'lote_id' => $lote['id'],
                        'movimiento_id' => $crearMovimiento->id,
                        'cantidad_anterior' => intval($lote["cantidad"]),
                        'cantidad_solicitada' => $cantidadRecibidad,
                        'cantidad_final' => abs(intval($lote["cantidad"]) + intval($cantidadRecibidad)),
                        'precio_unidad' => intval($detalleSolicitud['precio_unidad_aprobado']),
                        'valor_total' => intval($detalleSolicitud['precio_unidad_aprobado']) * intval($cantidadRecibidad),
                        'valor_promedio' => 0,
                        'bodega_medicamento_id' => $bodegaMedicamento['id'],
                    ]);

                    if (!$detalleMovimiento) {
                        throw new \Exception('Ocurrió un error al crear el detalle del movimiento', 422);
                    }

                    $actualizarDetalle = $this->detalleSolicitudBodegaRepository->actualizarDetalle($detalleSolicitud["id"],[
                        'estado_id' => ((intval($detalleSolicitud["cantidad_aprobada"]) - intval($lotes['cantidad']) === 0) ? 17 : 14),
                        'bodega_medicamento_id' => $bodegaMedicamento['id'],
                        'lote' => $lotes["lote"],
                        'cantidad_entregada' =>  intval($lotes['cantidad']),
                        'numero_factura' => $request['factura']
                    ]);

                    if (!$actualizarDetalle) {
                        throw new \Exception('Ocurrió un error al actualizar el detalle de la solicitud', 422);
                    }
                }
               }
            $this->solicitudBodegaService->recalcularCostoPromedio($medicamento_id);
            }
            $ordenCompra = $this->detalleSolicitudBodegaRepository->buscarPorEstado($solicitud->id,17);
            $ordenesCompraTotal = $this->detalleSolicitudBodegaRepository->buscarDetalleSolicitud($solicitud->id);
             if ($ordenesCompraTotal == $ordenCompra) {
                   $actualizarSolicitud = $this->solicitudBodegaRepository->actualizarSolicitudes($solicitud->id,['estado_id'=>17]);
                   if (!$actualizarSolicitud) {
                    throw new \Exception('Ocurrió un error al actualizar la solicitud', 422);
                }
                }
            DB::commit();
            return $ordenCompra;
        } catch (\Throwable $th) {
            DB::rollBack();
            throw $th;
        }



    }
}
