<?php

namespace App\Http\Modules\Facturacion;

use App\Http\Controllers\Controller;
use App\Http\Services\CodePymeService;
use App\Traits\ArchivosTrait;
use Carbon\Carbon;
use Illuminate\Http\Request;

class FacturaController extends Controller
{
    use ArchivosTrait;

    public function __construct(protected FacturaService $facturacionService, protected CodePymeService $codePymeService) {}

    public function listar()
    {
        try {
            $facturas = $this->facturacionService->listar();
            return response()->json($facturas, 200);
        } catch (\Throwable $th) {
            return response()->json(['message' => $th->getMessage()], 500);
        }
    }

    /**
     * crea una factura
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     * @author David Pelaez
     */
    public function crear(Request $request)
    {
        set_time_limit(0);
        try {
            $factura = $this->facturacionService->crear($request->all());
            return response()->json($factura, 201);
        } catch (\Throwable $th) {
            return response()->json(['message' => $th->getMessage()], 500);
        }
    }

    /**
     * Consulta una factura por su unique
     * @param string $unique
     * @return \Illuminate\Http\JsonResponse
     * @author David Pelaez
     */
    public function consultar(string $unique)
    {
        try {
            $factura = $this->facturacionService->consultar($unique);
            return response()->json($factura, 200);
        } catch (\Throwable $th) {
            return response()->json(['message' => $th->getMessage()], 500);
        }
    }

    /**
     * genera una url temporal para descargar el zip
     * @param string $unique
     * @return \Illuminate\Http\JsonResponse
     * @author David Peláez
     */
    public function descargarZip(string $unique)
    {
        try {
            $factura = $this->facturacionService->consultar($unique);
            $temporaryUrl = $this->generarUrlTemporal($factura->zip, Carbon::now()->addDay());
            return response()->json($temporaryUrl);
        } catch (\Throwable $th) {
            return response()->json($th, 500);
        }
    }

    /**
     * emite una factura directamente a la dian
     * @param string $unique
     * @return \Illuminate\Http\JsonResponse
     */
    public function emitirDian(string $unique)
    {
        try {
            $factura = $this->facturacionService->consultar($unique);
            $facturaEmitida = $this->codePymeService->emitirFactura($factura->toArray());
            return response()->json($facturaEmitida);
        } catch (\Throwable $th) {
            return response()->json($th, 500);
        }
    }

    /**
     * genera el soporte de una factura
     * @param string $unique
     * @return \Illuminate\Http\JsonResponse
     * @author David Peláez
     */
    public function generarSoporte(string $unique){
        try {
            $soporte = $this->facturacionService->generarSoporte($unique);
            return response()->json($soporte);
        } catch (\Throwable $th) {
            return response()->json($th, 500);
        }
    }
}
