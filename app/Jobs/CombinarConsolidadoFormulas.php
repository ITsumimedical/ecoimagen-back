<?php

namespace App\Jobs;

use App\Http\Modules\PDF\Services\PdfService;
use App\Traits\ArchivosTrait;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;

class CombinarConsolidadoFormulas implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, ArchivosTrait, SerializesModels;

    private string $carpeta;

    /**
     * Create a new job instance.
     */
    public function __construct(string $carpeta)
    {
        $this->carpeta = $carpeta;
    }

    /**
     * Execute the job.
     */
    public function handle(PdfService $pdfService): void
    {
        Log::channel('consolidados')->info('Iniciando la combinación de archivos PDF en la carpeta: ' . $this->carpeta);
        # obtengo los archivos de la carpeta temporal
        $carpetas = File::directories(storage_path('app/' . $this->carpeta));

        foreach ($carpetas as $carpeta) {
            $archivos = File::files($carpeta);
            $carpetaExplode = explode('/', $carpeta);
            $identificacion = end($carpetaExplode);
            [$sigla, $documento] = explode('-', $identificacion);

            $archivosAgrupados = collect($archivos)
                ->map(function ($archivo){
                    return $archivo->getFilename();
                })
                ->groupBy(function ($archivo) {
                    $nombre = $archivo;
                    if (Str::startsWith($nombre, '6-')) {
                        return '6';
                    } elseif (Str::startsWith($nombre, '9-')) {
                        return '9';
                    }
                    return 'otros';
                });

            foreach ($archivosAgrupados as $tipo => $archivos) {

                $archivosACombinar = $archivos->map(function ($archivo) use ($carpeta) {
                    return $carpeta . '/' . $archivo;
                });
                $arrayDeArchivos = $archivosACombinar->toArray();
                try {
                    $pdfService->combinarPDFs($arrayDeArchivos, storage_path('app/' . $this->carpeta . '/' . $tipo . '-' . $sigla . $documento . '.pdf'));
                } catch (\Throwable $th) {
                    continue;
                }
            }
            # eliminamos la carpeta contenedora de los archivos
            $this->deleteFolder(storage_path('app/' . $this->carpeta . '/' . $identificacion));
        }
    }

    public function failed(\Throwable $exception)
    {
        Log::channel('consolidados')->error('Error al combinar archivos PDF en la carpeta: ' . $this->carpeta, [
            'error' => $exception->getMessage(),
            'trace' => $exception->getTraceAsString(),
        ]);
    }
}
