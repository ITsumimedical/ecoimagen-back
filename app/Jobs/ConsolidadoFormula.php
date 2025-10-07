<?php

namespace App\Jobs;

use App\Formats\Medicamentos\Comprobante;
use App\Formats\Medicamentos\Formula;
use App\Http\Modules\Medicamentos\Repositories\OrdenamientoRepository;
use App\Http\Modules\Ordenamiento\Models\Orden;
use Exception;
use Illuminate\Bus\Batchable;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;

class ConsolidadoFormula implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels, Batchable;

    public $orden;
    public $carpeta;
    public $fecha;
    
    /**
     * Create a new job instance.
     */
    public function __construct(Orden $orden, string $carpeta, string $fecha)
    {
        $this->orden = $orden;
        $this->carpeta = $carpeta;
        $this->fecha = $fecha;
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        try {
            $carpetaAfiliado = $this->carpeta . '/' . $this->orden->consulta->afiliado->tipoDocumento->sigla . '-' . $this->orden->consulta->afiliado->numero_documento;
            # creamos la carpeta del afiliado
            # verificamos que la carpeta no exista
            if (!file_exists(storage_path('app/' . $carpetaAfiliado))) {
                mkdir(storage_path('app/' . $carpetaAfiliado), 0777, true);
            }
            $objComprobante = new Comprobante();
            $nombreComprobante = $carpetaAfiliado . '/6-' . uniqid() . '.pdf';
            $objComprobante->generar($this->orden, $nombreComprobante, $this->fecha);
            
            $objFormula = new Formula();
            $nombreFormula = $carpetaAfiliado . '/9-' . uniqid() . '.pdf';
            $objFormula->generar($this->orden, $nombreFormula);
        } catch (\Exception $e) {
            Storage::append($this->carpeta . '/errores.txt', $this->orden->id . ': ' . $e->getMessage());
            Log::channel('consolidados')->error('El job ConsolidadoFormula falló: ' . $e->getMessage());
        } finally {
            unset($objComprobante, $objFormula);
        }
    }

    public function failed(Exception $exception)
    {
        // Puedes registrar el error en logs
        Log::channel('consolidados')->error('El job ConsolidadoFormula falló: ' . $exception->getMessage());
    }

}
