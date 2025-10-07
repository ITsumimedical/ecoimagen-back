<?php

namespace App\Jobs;

use App\Formats\Medicamentos\Formula;
use App\Http\Modules\Ordenamiento\Models\Orden;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;

class FormulaMedica implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Create a new job instance.
     */
    public function __construct(private int $id, private string $nombre, private string $carpeta, private array $errores = [])
    {
        $this->id = $id;
        $this->nombre = $nombre;
        $this->carpeta = $carpeta;
        $this->errores = $errores;
    }

    /**
     * Execute the job.
     */
    public function handle(Formula $formula): void
    {
        if (Storage::exists($this->nombre) || in_array($this->id, $this->errores)) {
            Log::channel('consolidados')->error('El archivo ya existe: ' . $this->id);
            return;
        }
        try {
            $ordenArticulo = Orden::where('id', $this->id)
                ->first();
            $formula->generar($ordenArticulo, $this->nombre);
            Log::channel('consolidados')->info('Archivo generado: ' . $this->id);
        } catch (\Throwable $th) {
            Log::channel('consolidados')->error('Error al generar el archivo: ' . $this->id . ' ' . $th->getMessage());
        }
    }
}
