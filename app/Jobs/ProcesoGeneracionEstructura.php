<?php

namespace App\Jobs;

use App\Http\Modules\FacturacionElectronica\Services\EstructuraFacturacionElectronicaService;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use App\Services\DocumentService;
use Illuminate\Support\Facades\Log;

class ProcesoGeneracionEstructura implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $documentData;

    /**
     * El número de veces que el Job puede ser intentado.
     */
    public $tries = 3;

    /**
     * El número de segundos que el Job puede ejecutarse antes de que se agote el tiempo.
     */
    public $timeout = 120; // 2 minutos, ajusta según la complejidad de la facturación

    /**
     * Create a new job instance.
     *
     * @param array $documentData Los datos validados del documento a procesar.
     */
    public function __construct(array $documentData)
    {
        $this->documentData = $documentData;
    }

    /**
     * Execute the job.
     *
     * @param DocumentService $documentService Laravel inyectará automáticamente el servicio.
     */
    public function handle(EstructuraFacturacionElectronicaService $estructuraService): void
    {
        Log::info('Iniciando procesamiento de Job para documento.', ['number' => $this->documentData['number'] ?? 'N/A']);

        // try {
        //     // Llama al servicio para crear el documento en la base de datos
        //     $estructura = $estructuraService->createDocument($this->documentData);

        //     Log::info('Documento ' . $estructura->id . ' creado exitosamente en la DB.', ['number' => $estructura->number]);

        //     // *** Opcional: Lógica adicional que requiere el documento ya persistido ***
        //     // Aquí es donde invocarías otras funciones del servicio que realizan
        //     // operaciones lentas o externas.
        //     $estructuraService->sendDocumentToExternalAPI($document);
        //     // $documentService->generateDocumentPdf($document);
        //     // Mail::to($document->establishment_email)->send(new DocumentConfirmationMail($document));

        // } catch (\Throwable $e) {
        //     // Manejo de errores detallado. El Job fallará y, si está configurado, será reintentado.
        //     Log::error('Error al procesar el Job ProcessDocumentCreation para el documento ' .
        //                 ($this->documentData['number'] ?? 'N/A') . ': ' . $e->getMessage(), [
        //                     'exception' => $e,
        //                     'document_data' => $this->documentData,
        //                     'job_id' => $this->job->getJobId() ?? 'N/A' // ID del Job en la cola
        //                 ]);

        //     // Si quieres que el Job se marque como "fallido" y no se reintente, puedes usar:
        //     // $this->fail($e); // Esto detiene los reintentos y marca el Job como fallido.
        //     // O simplemente lanzar la excepción para que el Job reintente hasta alcanzar $tries.
        //     throw $e;
        }

        // Log::info('Job de procesamiento de documento finalizado.', ['number' => $this->documentData['number'] ?? 'N/A']);
    // }
}
