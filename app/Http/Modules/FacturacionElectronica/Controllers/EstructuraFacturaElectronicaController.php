<?php

namespace App\Http\Modules\FacturacionElectronica\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Modules\Facturacion\FacturaDetalleItemRepository;
use App\Http\Modules\FacturacionElectronica\Repositories\EstructuraFacturaElectronicaRepository;
use App\Http\Modules\FacturacionElectronica\Requests\CrearConceptoPreFacturaRequest;
use App\Http\Modules\FacturacionElectronica\Requests\EstructuraFacturaElectronicaRequest;
use App\Http\Modules\FacturacionElectronica\Services\EstructuraFacturacionElectronicaService;
use App\Jobs\ProcesoGeneracionEstructura;
use Illuminate\Auth\Events\Validated;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Log;

class EstructuraFacturaElectronicaController extends Controller
{

    public function __construct(
        protected EstructuraFacturaElectronicaRepository $estructuraFacturaElectronicaRepository,
        protected EstructuraFacturacionElectronicaService  $estructuraFacturacionElectronicaService,
        protected FacturaDetalleItemRepository $facturaDetalleItemRepository,
    ) {}

    /**
     * Proceso para listar las facturas pendientes de ser facturadas electrónicamente
     *
     * @param $request
     * @return void
     */
    public function facturasPendientesDeFacturacionElectronica(Request $request)
    {
        try {
            $items = $this->facturaDetalleItemRepository->listar($request->all());
            return response()->json($items, Response::HTTP_OK);
        } catch (\Throwable $th) {
            return response()->json(['mensaje' => $th->getMessage()], Response::HTTP_BAD_REQUEST);
        }
    }

    public function crearEstructura(EstructuraFacturaElectronicaRequest $request) //: JsonResponse
    {
        try {
            ProcesoGeneracionEstructura::dispatch($request->validated());

            return response()->json([
                'message' => 'Solicitud de creación de documento recibida y en procesamiento. Recibirás una notificación cuando esté completado.'
            ], 202); // 202 Accepted
        } catch (\Throwable $e) { // Captura cualquier error inesperado
            Log::error('Error al despachar job de creación de documento: ' . $e->getMessage(), [
                'trace' => $e->getTraceAsString(),
                'request_data' => $request->all()
            ]);
            return response()->json([
                'message' => 'Error interno del servidor al procesar la solicitud.',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    public function emitirPreFactura(Request $request)
    {
        try {
            $serviciosFacturados = $this->estructuraFacturaElectronicaRepository->preFactura($request->all());
            return response()->json($serviciosFacturados, Response::HTTP_OK);
        } catch (\Throwable $e) {
            return response()->json(['message' => $e->getMessage()], Response::HTTP_BAD_REQUEST);
        }
    }

    public function crearConceptoPreFactura(CrearConceptoPreFacturaRequest $request)
    {
        try {
            $concepto = $this->estructuraFacturacionElectronicaService->crearConceptoPreFactura($request->validated());
            return response()->json($concepto, Response::HTTP_OK);
        } catch (\Throwable $e) {
            return response()->json(['message' => $e->getMessage()], Response::HTTP_BAD_REQUEST);
        }
    }

    public function listarConceptoPreFactura() {
        try {
            $concepto = $this->estructuraFacturaElectronicaRepository->listarConceptoPreFactura();
            return response()->json($concepto, Response::HTTP_OK);
        } catch (\Throwable $e) {
            return response()->json(['message' => $e->getMessage()], Response::HTTP_BAD_REQUEST);
        }
    }
}
