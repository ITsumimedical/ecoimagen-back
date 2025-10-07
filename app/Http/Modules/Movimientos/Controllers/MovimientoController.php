<?php

namespace App\Http\Modules\Movimientos\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Http\Controllers\Controller;
use App\Http\Modules\Medicamentos\Models\Lote;
use App\Http\Modules\Movimientos\Models\Movimiento;
use App\Http\Modules\Medicamentos\Models\BodegaMedicamento;
use App\Http\Modules\SolicitudBodegas\Models\SolicitudBodega;
use App\Http\Modules\DetalleSolicitudLote\Models\DetalleSolicitudLote;
use App\Http\Modules\DetalleSolicitudBodegas\Models\DetalleSolicitudBodega;
use App\Http\Modules\HistoricoPrecioProveedorMedicamento\Models\HistoricoPrecioProveedorMedicamento;
use App\Http\Modules\Medicamentos\Models\PrecioProveedorMedicamento;
use App\Http\Modules\Movimientos\Models\DetalleMovimiento;
use App\Http\Modules\Movimientos\Repositories\MovimientoRepository;
use App\Http\Modules\Movimientos\Services\MovimientoService;
use App\Http\Modules\SolicitudBodegas\Models\NovedadSolicitudes;

class MovimientoController extends Controller
{
    public function __construct(protected MovimientoService $movimientoService, protected MovimientoRepository $movimientoRepository) {}

    public function guardar(Request $request, $tipo)
    {
        // return $request['solicitud'][0]['solicitud_bodega_id'];
        // return $request;
        try {
            $data = $this->movimientoService->guardar($request,$tipo);
            return response()->json($data, 200);
        } catch (\Throwable $th) {
            return response()->json($th->getMessage(), 400);
        }
    }

    public function listarDispensacion($id)
    {
        try {
            $data = $this->movimientoService->listarDispensacion($id);
            return response()->json([
                'data' => $data

            ], 200);
        } catch (\Throwable $th) {
            return response()->json([
                'error' => $th->getMessage(),
                'mensaje' => 'Error al consultar la dispensación',
            ], 400);
        }
    }
    public function verificarExistenciFactura($factura)
    {
        try {
            $factura = $this->movimientoRepository->verificarExistenciaFactura($factura);
            return response()->json($factura);
        } catch (\Throwable $th) {
            return response()->json(['error' => $th->getMessage()], 400);
        }
    }

    public function entradaConsignacion(Request $request)
    {
        try {
           return $this->movimientoService->movimientoConsignacion($request->all());
        } catch (\Throwable $th) {
            return response()->json(['error' => $th->getMessage()], 400);
        }
    }

    public function guardarFirmaRecibe(int $movimiento_id, Request $request){
        try {
            $consulta = $this->movimientoService->guardarFirmaRecibe($movimiento_id, $request);
            return response()->json($consulta, 200);
        } catch (\Throwable $th) {
            return response()->json([
                'res' => false,
                'error' => $th->getMessage(),
                'mensaje' => 'Error al cancelar la consultas.',
            ], Response::HTTP_BAD_REQUEST);
        }
    }
}
