<?php

namespace App\Jobs;

use App\Http\Services\ZipService;
use App\Traits\ArchivosTrait;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;

class ComprimirCarpeta implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, ArchivosTrait, SerializesModels;

    /**
     * Create a new job instance.
     */
    public function __construct(
        private string $carpeta
    ) {}

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        try {
            # generamos el zip con los archivos combinados
            $zipService = new ZipService();
            $zipService->crear(storage_path('app/' . $this->carpeta), str_replace('tmp/', '', $this->carpeta) . '.zip');
            # eliminamos la carpeta temporal
            $this->deleteFolder(storage_path('app/' . $this->carpeta));
            # eliminamos la instancia del zipService
            unset($zipService);
        } catch (\Throwable $th) {
            Log::channel('consolidados')->error('Error al comprimir el consolidado de : ' . $th->getMessage(), [
                'exception' => $th,
            ]);
            throw $th;
        }
    }
}
