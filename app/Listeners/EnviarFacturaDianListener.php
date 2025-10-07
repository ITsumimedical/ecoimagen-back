<?php

namespace App\Listeners;

use App\Events\FacturaCreadaEvent;
use App\Http\Modules\Facturacion\FacturaService;
use App\Http\Services\CodePymeService;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Facades\Storage;

class EnviarFacturaDianListener
{
    /**
     * Create the event listener.
     */
    public function __construct(
        private CodePymeService $codePymeService,
        private FacturaService $facturaService,
    ) {}

    /**
     * Handle the event.
     */
    public function handle(FacturaCreadaEvent $event): void
    {
        $event->factura->load('cliente', 'resolucion', 'detalles');
        $data = $event->factura->toArray();
        $response = $this->codePymeService->emitirFactura($data);
        $zipPath = $this->subirArchivo($response['zipinvoicexml'], $event->factura->numero . '.zip');

        $this->facturaService->actualizar($event->factura, [
            // 'dian_response' => $response['ResponseDian'],
            'zip' => $zipPath,
            'emitida' => true,
            'cufe' => $response['cufe'],
        ]);
    }

    /**
     * los archivos de la DIAN llegan en base 64 tocaria decodificarlos y subirlos al S3
     */
    private function subirArchivo(string $base64, string $nombreArchivo): string
    {
        $decoded = base64_decode($base64);
        $nombre = 'facturas/dian/' . $nombreArchivo;
        Storage::disk('digital')->put($nombre, $decoded);
        return $nombre;
    }
}
