<?php

namespace App\Http\Modules\SolicitudBodegas\Controllers;

use App\Http\Modules\DetalleSolicitudBodegas\Models\DetalleSolicitudBodega;
use App\Http\Modules\SolicitudBodegas\Models\SolicitudBodega;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Http\JsonResponse;
use App\Http\Controllers\Controller;
use App\Http\Modules\Bodegas\Models\Bodega;
use App\Http\Modules\HistoricoPrecioProveedorMedicamento\Models\HistoricoPrecioProveedorMedicamento;
use App\Http\Modules\HistoricoPrecioProveedorMedicamento\Repositories\HistoricoPrecioProveedorMedicamentoRepository;
use App\Http\Modules\Medicamentos\Models\Medicamento;
use App\Http\Modules\Medicamentos\Models\PrecioProveedorMedicamento;
use App\Http\Modules\TipoCitas\Models\TipoCita;
use App\Http\Modules\SolicitudBodegas\Repositories\SolicitudBodegaRepository;
use App\Http\Modules\SolicitudBodegas\Request\CargaMasivaComprasRequest;
use App\Http\Modules\SolicitudBodegas\Services\SolicitudBodegaService;
use Throwable;

//use App\Http\Modules\SolicitudBodegas\Requests\GuardarTipoCitaRequest;


class SolicitudBodegaController extends Controller
{
    private $solicitudBodegaRepository;

    public function __construct(
        private SolicitudBodegaService $solicitudBodegaService,
        private HistoricoPrecioProveedorMedicamentoRepository $historicoPrecioProveedorMedicamentoRepository
    ) {
        $this->solicitudBodegaRepository = new SolicitudBodegaRepository();
    }



    /**
     * guarda la solicitud de bodega
     * @param mixed $request
     * @return JsonResponse
     */
    public function crearAjusteEntrada(Request $request)
    {

        try {
            $solicitud = new SolicitudBodega($request->except(["articulos"]));
            $solicitud->usuario_solicita_id = auth()->user()->id;
            $solicitud->estado_id = 3;
            $nuevasolicitudBodega = $this->solicitudBodegaRepository->guardar($solicitud);

            $nuevoDetalleSolicitud = $this->solicitudBodegaRepository->crearDetalleAjusteEntrada($request["articulos"], $nuevasolicitudBodega->id, $request["bodega_destino_id"]);
            return response()->json($nuevoDetalleSolicitud);
        } catch (Throwable $th) {
            return response()->json($th->getMessage(), 400);
        }
    }

    /**
     * guarda la solicitud de compras
     * @param mixed $request
     * @return JsonResponse
     */
    public function crearSolicitudCompra(Request $request)
    {
       try {
         $solicitudCompra = $this->solicitudBodegaService->crearSolicitudCompra($request);
         return response()->json($solicitudCompra);
       } catch (\Throwable $th) {
        return response()->json(['error' => $th->getMessage()], 400);
       }
    }

    public function listar($solicitud, $estado, $bodega)
    {
        return response()->json(SolicitudBodega::where('tipo_solicitud_bodega_id', $solicitud)->where('bodega_origen_id', $bodega)
            ->where('estado_id', $estado)
            ->with([
                'usuarioSolicita',
                'usuarioSolicita.operador:id,user_id,nombre,apellido',
                'detallesSolicitud' => function ($query) use ($estado) {
                    return $query->where('estado_id', $estado);
                },
                'rep:id,nombre,codigo',
                'detallesSolicitud.novedades',
                'detallesSolicitud.lotes',
                'bodegaDestino',
                'detallesSolicitud.medicamento:id,cum,codesumi_id',
                'detallesSolicitud.medicamento.invima:id,cum_validacion,titular,producto,descripcion_comercial',
                'detallesSolicitud.medicamento.codesumi:id,nombre,codigo'
            ])->get());
    }

    public function listarDetalle($solicitud, $bodega)
    {
        return response()->json(
            DetalleSolicitudBodega::select([
                'detalle_solicitud_bodegas.*',
                'sb.bodega_origen_id',
                'sb.bodega_destino_id',
                'sb.estado_id as estado_solicitud_id',
                'b1.nombre as bodega_origen',
                'b2.nombre as bodega_destino'
            ])
                ->join('solicitud_bodegas as sb', 'sb.id', 'detalle_solicitud_bodegas.solicitud_bodega_id')
                ->leftjoin('bodegas as b1', 'b1.id', 'sb.bodega_origen_id')
                ->leftjoin('bodegas as b2', 'b2.id', 'sb.bodega_destino_id')
                ->where('sb.tipo_solicitud_bodega_id', $solicitud)
                ->where('sb.bodega_origen_id', $bodega)
                ->where('sb.estado_id', 3)
                ->where('detalle_solicitud_bodegas.estado_id', 3)
                ->get()
        );
    }

    public function aprobarSolicitud(Request $request)
    {

        // return $request->proveedor;
        foreach ($request->detalles_solicitud as $detalles) {
            // return $detalles;
            $detalle = DetalleSolicitudBodega::find($detalles['id'])->update([
                "cantidad_aprobada" => $detalles["cantidad_aprobada"],
                "precio_unidad_aprobado" => $detalles["precio_unidad"],
                "estado_id" => intval($detalles["cantidad_aprobada"]) > 0 ? 4 : 5
            ]);

            PrecioProveedorMedicamento::updateOrCreate(
                [
                    'medicamento_id' => $detalles['medicamento_id'],
                    'rep_id' => $request->proveedor
                ],
                [
                    'precio_unidad' => abs($detalles["precio_unidad"])
                ]
            );
            HistoricoPrecioProveedorMedicamento::create([
                "precio_unidad" => abs($detalles["precio_unidad"]),
                "rep_id" => $request->proveedor,
                "medicamento_id" => $detalles['medicamento_id'],
                "solicitud_bodega_id" => $request->id

            ]);
            $this->solicitudBodegaService->recalcularCostoPromedio($detalles['medicamento_id']);
        }
        $proveedor = isset($request->proveedor) ? $request->proveedor : null;
        SolicitudBodega::find($request->id)->update(["estado_id" => 4, 'usuario_aprueba_id' => auth()->user()->id, "rep_id" => $proveedor]);
        return response()->json(["message" => "Solicitud Aprobada!"]);
    }

    public function rechazarSolicitud(Request $request)
    {
        try {
            $datos = $request->detalles_solicitud;

            foreach ($datos as $detalle) {
                DetalleSolicitudBodega::where('id', $detalle['id'])
                    ->update([
                        "cantidad_aprobada" => 0,
                        "lote" => null,
                        "estado_id" => 5,
                        "descripcion" => isset($request->descripcion) ? $request->descripcion : null
                    ]);
                //18
            }
            $contador = DetalleSolicitudBodega::where('solicitud_bodega_id', $request->id)->count();
            $contadorAnulados = DetalleSolicitudBodega::where('solicitud_bodega_id', $request->id)->where('estado_id', 5)->count();
            if ($contador == $contadorAnulados) {
                SolicitudBodega::find($request->id)->update([
                    "estado_id" => 5,
                    'usuario_aprueba_id' => auth()->user()->id,
                    'rep_id' => isset($request->proveedor_id) ? $request->proveedor_id : null
                ]);
            } else {
                SolicitudBodega::find($request->id)->update([
                    "estado_id" => 18,
                    'usuario_aprueba_id' => auth()->user()->id,
                    'rep_id' => isset($request->proveedor_id) ? $request->proveedor_id : null
                ]);
            }

            return response()->json(["message" => "Solicitud Rechazada!"]);
        } catch (Throwable $th) {
            return response()->json($th->getMessage(), 400);
        }
    }

    public function aprobarSolicitudDetalle(Request $request)
    {
        try {
            DetalleSolicitudBodega::where("id", $request->id)
                ->update([
                    "cantidad_aprobada" => $request->cantidad_aprobada,
                    "lote" => $request->lote,
                    "estado_id" => intval($request->cantidad_aprobada) > 0 ? 4 : 5
                ]);
            return response()->json(["message" => "Solicitud Aprobada!"]);
        } catch (Throwable $th) {
            return response()->json($th->getMessage(), 400);
        }
    }

    public function aprobarSolicitudTraslado(Request $request)
    {
        try {
            $aprobacion = $this->solicitudBodegaService->aprobarSolicitudTraslado($request->all());
            return response()->json($aprobacion, 200);
        } catch (\Throwable $th) {
            return response()->json($th->getMessage(), 400);
        }
    }

    public function importarExcel(Request $request)
    {
        // return $request->all();
        try {
            $aprobacion = $this->historicoPrecioProveedorMedicamentoRepository->importarExcel($request->all());
            return $aprobacion;
        } catch (\Throwable $th) {
            return response()->json($th->getMessage(), 400);
        }
    }

    public function cargaMasiva(Request $request)
    {
        try {
            $aprobacion = $this->solicitudBodegaService->cargaMasiva($request->all());
            return response()->json($aprobacion, 200);
        } catch (\Throwable $th) {
            return response()->json($th->getMessage(), 400);
        }
    }

    public function guardarAjusteEntrada(Request $request)
    {
        try {
            $aprobacion = $this->solicitudBodegaService->guardarAjusteEntrada($request->all());
            return response()->json($aprobacion, 200);
        } catch (\Throwable $th) {
            return response()->json($th->getMessage(), $th->getCode());
        }
    }
    public function guardarAjusteSalida(Request $request)
    {
        try {
            $aprobacion = $this->solicitudBodegaService->guardarAjusteSalida($request->all());
            return response()->json($aprobacion, 200);
        } catch (\Throwable $th) {
            return response()->json($th->getMessage(), $th->getCode());
        }
    }

    public function obtnerAjuste(Request $request)
    {
        try {
            $ajuste = $this->solicitudBodegaRepository->obtnerAjuste($request->all());
            return response()->json($ajuste, 200);
        } catch (\Throwable $th) {
            return response()->json($th->getMessage(), 400);
        }
    }

    public function solicitudCompras(Request $request)
    {
        try {
            $inventarioBodega = $this->solicitudBodegaRepository->solicitudCompras($request->all());
            return response()->json($inventarioBodega, 200);
        } catch (\Throwable $th) {
            return response()->json($th->getMessage(), 400);
        }
    }

    public function crearTraslado(Request $request)
    {
        try {
            $solicitud = new SolicitudBodega($request->except(["articulos"]));
            $solicitud->usuario_solicita_id = auth()->user()->id;
            $solicitud->estado_id = 3;
            $nuevasolicitudBodega = $this->solicitudBodegaRepository->guardar($solicitud);
            $nuevoDetalleSolicitud = $this->solicitudBodegaRepository->crearDetalleTraslado($request["articulos"], $nuevasolicitudBodega->id, $request["bodega_destino_id"]);
            return response()->json($nuevoDetalleSolicitud, 200);
        } catch (\Throwable $th) {
            return response()->json($th->getMessage(), 400);
        }
    }

    public function listarTraslado($solicitud, $estado, $bodega)
    {
        try {
            $lista = $this->solicitudBodegaRepository->listarTraslado($solicitud, $estado, $bodega);
            return response()->json($lista, 200);
        } catch (\Throwable $th) {
            return response()->json($th->getMessage(), 400);
        }
    }

    public function aprobarMovimientoTraslado(Request $request)
    {
        try {
            $aprobacion = $this->solicitudBodegaService->aprobarMovimientoTraslado($request->all());
            return response()->json($aprobacion, 200);
        } catch (\Throwable $th) {
            return response()->json($th->getMessage(), 400);
        }
    }

    public function rechazarSolicitudTraslado(Request $request)
    {
        try {
            $rechazar = $this->solicitudBodegaRepository->rechazarSolicitudTraslado($request);
            return response()->json(["message" => "Solicitud Rechazada!"]);
        } catch (Throwable $th) {
            return response()->json($th->getMessage(), 400);
        }
    }

    public function listarTrasladoPendiente($solicitud, $estado)
    {
        try {
            $lista = $this->solicitudBodegaRepository->listarTrasladoPendiente($solicitud, $estado);
            return response()->json($lista, 200);
        } catch (\Throwable $th) {
            return response()->json($th->getMessage(), 400);
        }
    }
    /**
     * Carga solicitudes desde un archivo Excel
     */
    public function cargarSolicitudesMasivas(CargaMasivaComprasRequest $request)
    {
        try {
            $archivo = $request->file('archivo');
            $resultado = $this->solicitudBodegaService->cargarSolicitudesComprasMasivas($archivo);
            return response()->json($resultado);
        } catch (Throwable $th) {
            return response()->json(['error' => $th->getMessage()], 500);
        }
    }

    /**
     * eliminarArchivo
     * Elimina el archivo generado del storage
     * @param  mixed $ruta
     * @return void
     */
    public function eliminarArchivoErrores(Request $request)
    {
        try {
            $eliminarArchivo = $this->solicitudBodegaService->eliminarArchivoErrores($request->nombreArchivo);
            return response()->json($eliminarArchivo);
        } catch (\Throwable $th) {
            return response()->json(['error' => $th->getMessage()], 400);
        }
    }

}
