<?php

namespace App\Jobs;

use App\Traits\ArchivosTrait;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Storage;

class SubirArchivo implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, ArchivosTrait, SerializesModels;
    /**
     * Create a new job instance.
     */
    public function __construct(
        private string $archivo,
        private string $ruta
    ) {}

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        $localPath = storage_path('app/' . $this->archivo) . '.zip';
        $stream = fopen($localPath, 'r');
        # subimos el zip al storage
        Storage::disk('digital')->writeStream($this->ruta . str_replace('tmp/', '', $this->archivo) . '.zip', $stream);
        fclose($stream);
        # eliminamos el archivo
        unlink($localPath);
    }
}
