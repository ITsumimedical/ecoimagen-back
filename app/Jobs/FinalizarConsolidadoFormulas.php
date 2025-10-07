<?php

namespace App\Jobs;

use App\Mail\ZipFormulasGenerado;
use Carbon\Carbon;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Storage;

class FinalizarConsolidadoFormulas implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    private $carpeta;
    private $ruta;
    private $fecha;
    private $email;

    /**
     * Create a new job instance.
     */
    public function __construct($carpeta, $ruta, $email, $fecha)
    {
        $this->carpeta = $carpeta;
        $this->ruta = $ruta;
        $this->email = $email;
        $this->fecha = $fecha;
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        # generamos un enlace temporal
        $temporaryUrl = Storage::disk('digital')->temporaryUrl($this->ruta . str_replace('tmp/', '', $this->carpeta) . '.zip', Carbon::now()->addDay());
        # enviamos un email con el enlace de descarga
        Mail::to($this->email)->send(new ZipFormulasGenerado($temporaryUrl, $this->fecha));
    }
}
