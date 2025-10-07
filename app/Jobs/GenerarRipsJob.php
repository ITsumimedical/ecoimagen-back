<?php

namespace App\Jobs;

use App\Http\Modules\LogRegistroRipsSumi\Services\LogRegistroRipsSumiService;
use App\Http\Modules\Rips\Services\RipService;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class GenerarRipsJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;
    // solo un intento
    public $tries = 1;
    // 10 Minutos de tiempo maximo de ejecucion del job
    public $timeout = 600;

    /**
     * Create a new job instance.
     */
    protected array $data;
    public function __construct(array $data)
    {
        $this->data = $data;
    }

    /**
     * Execute the job.
     */
    public function handle(RipService $ripService, LogRegistroRipsSumiService $logRegistroRipsSumiService): void
    {
        try {

            //entrada de datos

            $correo = $this->data['email'];
            $resolucion = $this->data['resolucion'];
            $user_id = $this->data['user_id'];
            $result = $ripService->generarRips($this->data);

            // normativa 2275

            if ($resolucion === '2275') {
                $ripService->enviarRipsJson2275($result, $correo);
            }

            // normativa 3374

            if ($resolucion === '3374') {
                $archivos = $ripService->generarContenidoArchivosTXT($result);
                $ripService->guardarArchivosYGenerarURLs($archivos, $this->data);
            }

            // guardado de log

            $logGenerado = [
                'codigo_http_respuesta' => 200,
                'mensaje_http_respuesta' => 'Rips generados con éxito',
                'user_id' => $user_id,
                'payload' => json_encode($this->data),
            ];

            $logRegistroRipsSumiService->crear($logGenerado);
        } catch (\Throwable $e) {

            //log de error 

            $logError = [
                'codigo_http_respuesta' => $e->getCode() ?: 500,
                'mensaje_http_respuesta' => $e->getMessage(),
                'user_id' => $user_id,
                'payload' => json_encode($this->data),
            ];

            $logRegistroRipsSumiService->crear($logError);
        }
    }
}
