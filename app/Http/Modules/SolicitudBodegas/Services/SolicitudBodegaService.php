<?php

namespace App\Http\Modules\SolicitudBodegas\Services;

use App\Http\Modules\Bodegas\Models\Bodega;
use Rap2hpoutre\FastExcel\FastExcel;
use App\Http\Modules\Medicamentos\Models\Lote;
use App\Http\Modules\Movimientos\Models\Movimiento;
use App\Http\Modules\Medicamentos\Models\Medicamento;
use App\Http\Modules\SolicitudBodegas\Models\SolicitudBodega;
use App\Http\Modules\Medicamentos\Repositories\LoteRepository;
use App\Http\Modules\Movimientos\Repositories\MovimientoRepository;
use App\Http\Modules\Movimientos\Repositories\DetalleMovimientoRepository;
use App\Http\Modules\DetalleSolicitudBodegas\Models\DetalleSolicitudBodega;
use App\Http\Modules\Medicamentos\Repositories\BodegaMedicamentoRepository;
use App\Http\Modules\SolicitudBodegas\Repositories\SolicitudBodegaRepository;
use App\Http\Modules\DetalleSolicitudBodegas\Repositories\DetalleSolicitudBodegaRepository;
use App\Http\Modules\DetalleSolicitudBodegas\Repositories\SolicitudDetalleBodegaLoteRepository;
use App\Http\Modules\DetalleSolicitudLote\Models\DetalleSolicitudLote;
use App\Http\Modules\Medicamentos\Models\BodegaMedicamento;
use App\Http\Modules\Movimientos\Models\DetalleMovimiento;
use App\Http\Modules\HistoricoPrecioProveedorMedicamento\Models\HistoricoPrecioProveedorMedicamento;
use Error;
use Exception;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Throwable;

class SolicitudBodegaService
{



    public function __construct(
        private DetalleSolicitudBodegaRepository $detalleSolicitudBodegaRepository,
        private SolicitudBodegaRepository $solicitudBodegaRepository,
        private LoteRepository $loteRepository,
        private BodegaMedicamentoRepository $bodegaMedicamentoRepository,
        private MovimientoRepository $movimientoRepository,
        private DetalleMovimientoRepository $detalleMovimientoRepository,
        private SolicitudDetalleBodegaLoteRepository $solicitudDetalleBodegaLoteRepository
    ) {
    }

    public function aprobarSolicitudTraslado($data)
    {
        // return $data;
         // se crea el moviento

        try {
                DB::beginTransaction();
            $movimiento = $this->movimientoRepository->guardarMovimientoTraslado($data['solicitud'],15);
            foreach ($data['detalle'] as $detalleSolicitud) {

                // se actualizan los lotes de los cuales se saco
                $cantidad =0;
                foreach($detalleSolicitud['lotes'] as $lote){
                    $lotes = Lote::find($lote['idlote']);
                    $lotes->cantidad -= $lote['cantidadLote'];
                    $lotes->save();
                $cantidad +=$lote['cantidadLote'];

                // se actualiza la tabla bodega medicamento con la cantidad total
                $bodegamedicamento = BodegaMedicamento::find($detalleSolicitud['bodega_medicamento_id']);
                $cantidadAnterior = $bodegamedicamento['cantidad_total'];
                $bodegamedicamento->cantidad_total -= $lote['cantidadLote'];
                $bodegamedicamento->save();

                // se crea el detalle de los lotes
                DetalleSolicitudLote::create(['cantidad'=>$lote['cantidadLote'],
                                            'lote_id'=>$lotes->id,
                                            'detalle_solicitud_bodega_id'=>$detalleSolicitud['id']]);

                 // se crea el detalle del movimiento
                 $this->detalleMovimientoRepository->guardarDetalleMovimientoTraslado($movimiento->id,$lote['cantidadLote'],$cantidadAnterior,$bodegamedicamento,$lote['idlote']);
                }

                // se actualiza el detalle de la solicitud
                $detalle = $this->detalleSolicitudBodegaRepository->consultarDetalle($detalleSolicitud['id'],$cantidad);

                $bodegaMedicamentoDestino = $this->bodegaMedicamentoRepository->buscarBodega($data['solicitud']['bodega_destino_id'],$detalleSolicitud['medicamento_id']);

                if(!$bodegaMedicamentoDestino){
                    $creacionBodega = $this->bodegaMedicamentoRepository->crear(['medicamento_id'=>$detalleSolicitud['medicamento_id'],
                    'bodega_id' => $data['solicitud']['bodega_destino_id'],
                    'cantidad_total' => 0,
                    'estado' => true ]);


                    if (!$creacionBodega) {
                        throw new \Exception('Ocurrió un error al actualizar la solicitud', 422);
                    }
                }
            }
            // se actualiza la solicitud
            $this->solicitudBodegaRepository->consultarSolicitud($data['solicitud']['id']);
            DB::commit();
            return '¡Traslado aceptado!';
        } catch (\Throwable $th) {
            DB::rollBack();
            throw $th;
        }

    }


    public function cargaMasiva($data)
    {
        $existe = [];
        $msg = [];


        (new FastExcel)->import($data['excel'], function ($line) use (&$existe, &$msg, &$data) {

            if ($line["CODIGO"]) {
                $articulo = Medicamento::whereHas('codesumi', function ($q) use ($line) {
                    $q->where('codigo', '=', $line["CODIGO"]);
                })->first();

                if ($articulo) {
                    $existe[] = ['articulo' => $articulo->toArray(), 'medicamento_id' => $articulo->id, 'cantidad_inicial' => $line["CANTIDAD"]];
                }
            }
        });
        return $existe;
    }

    public function guardarAjusteEntrada($data)
    {
        $movimiento = Movimiento::create([
            'tipo_movimiento_id' => $data['tipo'] == 3 ? 1 : 2,
            'bodega_origen_id' => $data['bodega_origen_id'],
            'solicitud_bodega_id' => $data['articulos'][0]['id'],
            'user_id' => auth()->user()->id
        ]);

        foreach ($data['articulos'] as $articulo) {

            $bodegaMedicamento = BodegaMedicamento::find($articulo['bodega_medicamento_id']);
            $lote = Lote::where('bodega_medicamento_id', $bodegaMedicamento->id)
            ->where('codigo', $articulo['lote'])
            ->first();

            if ($data['tipo'] == 3) {
                $lote->cantidad += $articulo['cantidad_inicial'];
            } else {
                if (intval($lote->cantidad) >= intval($articulo['cantidad_inicial'])) {
                    $lote->cantidad -= $articulo['cantidad_inicial'];
                } else {
                    throw new Error("No hay suficiente cantidad en el lote para ajustar.", 422);
                }
            }
            $lote->save();

            $sumalotes = Lote::where('bodega_medicamento_id', $bodegaMedicamento->id)->sum('cantidad');
            $cantidadAnterior = $bodegaMedicamento->cantidad_total;
            $bodegaMedicamento->cantidad_total = $sumalotes;
            $bodegaMedicamento->save();

            // Crea una transacción de detalle de movimiento
            $transaccion = new DetalleMovimiento();
            $transaccion->movimiento_id = $movimiento->id;
            $transaccion->bodega_medicamento_id = $bodegaMedicamento->id;
            $transaccion->cantidad_anterior = $cantidadAnterior;
            $transaccion->cantidad_solicitada = $articulo['cantidad_inicial'];
            $transaccion->cantidad_final = $bodegaMedicamento->cantidad_total;
            $transaccion->precio_unidad = 0;
            $transaccion->valor_total = 0;
            $transaccion->valor_promedio = 0;
            $transaccion->lote_id = $lote->id;
            $transaccion->save();

            // Actualiza el estado de la solicitud en detalle
            DetalleSolicitudBodega::where('id', $articulo['detalle_id'])
                ->update([
                    "estado_id" => 14,
                    "cantidad_aprobada" => $articulo['cantidad_inicial']
                ]);

            // Actualiza la solicitud de bodega
            SolicitudBodega::find($articulo['id'])->update([
                'usuario_aprueba_id' => auth()->user()->id
            ]);
        }
        return true;
    }



    public function guardarAjusteSalida($data)
    {
        $movimiento = Movimiento::create([
            'tipo_movimiento_id' => $data['tipo'] == 3 ? 1 : 2,
            'bodega_origen_id' => $data['bodega_origen_id'],
            'solicitud_bodega_id' => $data['articulos'][0]['id'],
            'user_id' => auth()->user()->id
        ]);

        foreach ($data['articulos'] as $articulo) {

            $bodegaMedicamento = BodegaMedicamento::find($articulo['bodega_medicamento_id']);
            $lote = Lote::where('bodega_medicamento_id', $bodegaMedicamento->id)
            ->where('codigo', $articulo['lote'])
            ->first();

            if ($data['tipo'] == 3) {
                $lote->cantidad += $articulo['cantidad_inicial'];
            } else {
                if (intval($lote->cantidad) >= intval($articulo['cantidad_inicial'])) {
                    $lote->cantidad -= $articulo['cantidad_inicial'];
                } else {
                    throw new Error("No hay suficiente cantidad en el lote para ajustar.", 422);
                }
            }
            $lote->save();

            $sumalotes = Lote::where('bodega_medicamento_id', $bodegaMedicamento->id)->sum('cantidad');
            $cantidadAnterior = $bodegaMedicamento->cantidad_total;
            $bodegaMedicamento->cantidad_total = $sumalotes;
            $bodegaMedicamento->save();

            // Crea una transacción de detalle de movimiento
            $transaccion = new DetalleMovimiento();
            $transaccion->movimiento_id = $movimiento->id;
            $transaccion->bodega_medicamento_id = $bodegaMedicamento->id;
            $transaccion->cantidad_anterior = $cantidadAnterior;
            $transaccion->cantidad_solicitada = $articulo['cantidad_inicial'];
            $transaccion->cantidad_final = $bodegaMedicamento->cantidad_total;
            $transaccion->precio_unidad = 0;
            $transaccion->valor_total = 0;
            $transaccion->valor_promedio = 0;
            $transaccion->lote_id = $lote->id;
            $transaccion->save();

            // Actualiza el estado de la solicitud en detalle
            DetalleSolicitudBodega::where('id', $articulo['detalle_id'])
                ->update([
                    "estado_id" => 14,
                    "cantidad_aprobada" => $articulo['cantidad_inicial']
                ]);

            // Actualiza la solicitud de bodega
            SolicitudBodega::find($articulo['id'])->update([
                'usuario_aprueba_id' => auth()->user()->id
            ]);
        }
        return true;
    }

    public function aprobarMovimientoTraslado($data)
    {
         // se crea el moviento
        foreach ($data['detalle'] as $detalleSolicitud) {
            $movimiento = $this->movimientoRepository->guardarMovimientoTraslado($detalleSolicitud['solicitud_bodega'],10);
            $cantidad =0;
            // se actualizan los lotes de los cuales se saco
            $detalleLote = DetalleSolicitudLote::where('detalle_solicitud_bodega_id',$detalleSolicitud['id'])->get();
            foreach($detalleLote as $lote){
                $bodegamedicamento = BodegaMedicamento::where('medicamento_id',$detalleSolicitud['medicamento_id'])
                ->where('bodega_id',$detalleSolicitud['solicitud_bodega']['bodega_destino_id'])->first();
               $loteViejo= Lote::find($lote['lote_id']);
               $loteNuevo = Lote::where('bodega_medicamento_id',$bodegamedicamento['id'])->where('codigo',$loteViejo->codigo)->first();
               if(!$loteNuevo){
               $crear= Lote::create([
                    'codigo'=>$loteViejo->codigo,
                    'cantidad'=>$lote['cantidad'],
                    'fecha_vencimiento' =>$loteViejo->fecha_vencimiento,
                    'bodega_medicamento_id'=>$bodegamedicamento->id,
                    'estado_id'=>1
                ]);
                $idLote=$crear->id;
            }else{
                $loteNuevo->cantidad += $lote['cantidad'];
                $loteNuevo->save();
                $idLote = $loteNuevo->id;
            }
                $cantidad +=$lote['cantidad'];

            // se busca y se actualiza la tabla bodega medicamento con la cantidad total

             $cantidadAnterior = $bodegamedicamento['cantidad_total'];
             $bodegamedicamento->cantidad_total += $lote['cantidad'];
             $bodegamedicamento->save();
            //   // se crea el detalle del movimiento
              $this->detalleMovimientoRepository->guardarDetalleMovimientoTraslado($movimiento->id,$lote['cantidad'],$cantidadAnterior,$bodegamedicamento,$idLote);
            }

            // se actualiza el detalle de la solicitud
            $detalle = $this->detalleSolicitudBodegaRepository->actualizarDetalleTraslado($detalleSolicitud['id'],$cantidad);
        }
        // // se actualiza la solicitud
        // $this->solicitudBodegaRepository->actualizarSolicitud($data['solicitud']['id']);
         return '¡Traslado aceptado!';
    }
    public function crearSolicitudCompra($request)
    {
        try {
            $solicitud = new SolicitudBodega($request->except(["articulos"]));
            $solicitud->usuario_solicita_id = auth()->user()->id;
            $solicitud->estado_id = 3;
            $nuevasolicitudBodega = $this->solicitudBodegaRepository->guardar($solicitud);
            $nuevoDetalleSolicitud = $this->solicitudBodegaRepository->crearDetalleCompra($request->all(),$nuevasolicitudBodega->id);
            return ($nuevoDetalleSolicitud);
        } catch (Throwable $th) {
            return [
                'error' => $th->getMessage(),
                'mensaje' => 'Error al genera las solcitud',
            ];
        }
    }


    /**
     * procesarExcel
     * Se procesa el excel y se leen los datos para la carga masiva
     * @param  mixed $archivo
     * @return void
     */
    public function cargarSolicitudesComprasMasivas($archivo)
    {
        try {
            DB::beginTransaction();

            $solicitudes = (new FastExcel)->import($archivo);
            $errores = [];

            if (empty($solicitudes)) {
                return ['mensaje' => 'El archivo no contiene datos.'];
            }

            // Validar que las cabeceras del archivo sean correctas
            $cabecerasEsperadas = ['bodega_origen', 'cum', 'cantidad'];
            $cabecerasArchivo = array_keys((array) $solicitudes[0] ?? []);

            $faltantes = array_diff($cabecerasEsperadas, $cabecerasArchivo);
            if (!empty($faltantes)) {
                throw new Error('El archivo no tiene los datos esperadas', 400);
            }


            // Obtener la primera bodega ya que todas deben ser iguales
            $bodegaOrigen = trim($solicitudes[0]['bodega_origen'] ?? '');

            // Validar existencia de la bodega
            if (!($bodega = $this->validarBodega($bodegaOrigen))) {
                return ['mensaje' => "La bodega '{$bodegaOrigen}' no existe."];
            }


            $solicitudBodega = SolicitudBodega::create([
                'bodega_origen_id' => $bodega->id,
                'tipo_solicitud_bodega_id' => 1,
                'bodega_destino_id' => $bodega->id,
                'usuario_solicita_id' => Auth::id(),
                'estado_id' => 3,
                'created_at' => now(),
                'updated_at' => now(),
            ]);


            foreach ($solicitudes as $index => $data) {
                $fila = $index + 2;

                // Se realiza trim para evitar errores por espacios en el Excel
                $data['cum'] = trim($data['cum'] ?? '');

                // 1️ Validar existencia de CUM en la base de datos
                if (!$this->validarExistenciaCum($data['cum'])) {
                    $errores[] = ['fila' => $fila, 'error' => "El CUM '{$data['cum']}' no existe en la base de datos."];
                    continue;
                }

                // 2️ Validar existencia del medicamento en la bodega
                if (!($medicamento = $this->validarMedicamento($data['cum'], $bodega->id))) {
                    $errores[] = ['fila' => $fila, 'error' => "El CUM '{$data['cum']}' no pertenece a la bodega '{$data['bodega_origen']}'."];
                    continue;
                }

                // 3️ Validar cantidad
                if (!isset($data['cantidad']) || !is_numeric($data['cantidad']) || $data['cantidad'] <= 0) {
                    $errores[] = ['fila' => $fila, 'error' => "La cantidad debe ser un número positivo."];
                    continue;
                }

                // Agregar detalles de la solicitud
                $detallesSolicitud[] = [
                    'solicitud_bodega_id' => $solicitudBodega->id,
                    'medicamento_id' => $medicamento->medicamento_id,
                    'cantidad_inicial' => $data['cantidad'],
                    'estado_id' => 3,
                    'created_at' => now(),
                    'updated_at' => now(),
                ];
            }

            // Si hay errores, generar archivo y devolverlo
            if (!empty($errores)) {
                DB::rollBack();
                return $this->generarArchivoErrores($errores);
            }

            // Insertar los detalles de la solicitud
            DetalleSolicitudBodega::insert($detallesSolicitud);

            DB::commit();

            return [
                'mensaje' => 'Solicitud de bodega creada correctamente',
                'solicitud_id' => $solicitudBodega->id
            ];
        } catch (Throwable $th) {
            DB::rollBack();
            throw $th;
        }
    }



    /**
     * Valida que la bodega exista
     */
    public function validarBodega($nombreBodega)
    {
            return Bodega::where('nombre', $nombreBodega)->first();
    }

    /**
     * Valida que el medicamento con el CUM exista en la bodega
     */
    public function validarMedicamento($cum, $bodegaId)
    {
        return Medicamento::whereBodega($bodegaId)
            ->where('medicamentos.cum', $cum)
            ->first();
    }

    public function validarExistenciaCum($cum)
    {
        return Medicamento::where('cum', $cum)->exists();
    }

    /**
     * Genera un archivo Excel con los errores y lo devuelve para la descarga
     */
    public function generarArchivoErrores($errores)
    {
        $carpeta = storage_path('app/public/errores_solicitudes_bodegas');
        if (!file_exists($carpeta)) {
            mkdir($carpeta, 0777, true);
        }

        $nombreArchivo = 'errores_' . now()->timestamp . '.xlsx';
        $ritaArchivo = $carpeta . '/' . $nombreArchivo;

        // Exportar el archivo
        (new FastExcel(collect($errores)))->export($ritaArchivo);

        if (!file_exists($ritaArchivo)) {
            return response()->json(['mensaje' => 'Error al generar el archivo de errores'], 500);
        }

        $ruta = url(Storage::url("errores_solicitudes_bodegas/{$nombreArchivo}"));
        return(['mensaje' => 'Archivo de errores generado con éxito',
            'archivo_url' => $ruta
        ]);
    }


    public function eliminarArchivoErrores($nombreArchivo)
    {

        $ruta = "public/errores_solicitudes_bodegas/" . $nombreArchivo;
        if (Storage::exists($ruta)) {
            Storage::delete($ruta);
            return true;
        }
        throw new Exception('Archivo no encontrado', 400);
    }

    public function recalcularCostoPromedio($id)
    {
        try{
            $medicamento = Medicamento::find($id);
            $datos = HistoricoPrecioProveedorMedicamento::select([
                'detalle_solicitud_bodegas.numero_factura',
                'historico_precio_proveedor_medicamentos.medicamento_id',
                'historico_precio_proveedor_medicamentos.precio_unidad',
                'detalle_solicitud_bodegas.cantidad_aprobada',
                DB::raw("(historico_precio_proveedor_medicamentos.precio_unidad*detalle_solicitud_bodegas.cantidad_aprobada) as valor_total")
            ])->join('detalle_solicitud_bodegas', function ($join) {
                $join->on('detalle_solicitud_bodegas.solicitud_bodega_id', '=', 'historico_precio_proveedor_medicamentos.solicitud_bodega_id');
                $join->on('detalle_solicitud_bodegas.medicamento_id', '=', 'historico_precio_proveedor_medicamentos.medicamento_id');
            })->where('historico_precio_proveedor_medicamentos.medicamento_id', $medicamento->id)
                ->where('detalle_solicitud_bodegas.estado_id', 17)
                ->groupBy('detalle_solicitud_bodegas.numero_factura', 'historico_precio_proveedor_medicamentos.medicamento_id', 'historico_precio_proveedor_medicamentos.precio_unidad', 'detalle_solicitud_bodegas.cantidad_aprobada')
                ->get()->toArray();
            $valorTotal = array_sum(array_column($datos, 'valor_total'));
            $cantidadTotal = array_sum(array_column($datos, 'cantidad_aprobada'));
            if ($valorTotal > 0 && $cantidadTotal > 0) {
                $costoPromedio = round($valorTotal / $cantidadTotal, 2);
                $medicamento->costo_promedio = $costoPromedio;
                return $medicamento->save();
            }
            return false;
        }catch(\Exception $e){
            return false;
        }
    }

}
