<?php

namespace App\Jobs;

use App\Enums\TipoDocumentoEnum;
use App\Formats\HistoriaClinicaIntegralBase;
use App\Http\Modules\Consultas\Repositories\ConsultaRepository;
use App\Http\Modules\PDF\Services\PdfService;
use Carbon\Carbon;
use Illuminate\Bus\Batchable;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\File;

class GeneracionZipHistorias implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels, Batchable;

    public $timeout = 300;

    public $afiliado;
    public $parametros;
    public $carpetaBase;
    public $carpetaStorage;

    /**
     * Create a new job instance.
     * 
     */
    public function __construct(
        array $afiliado,
        array $parametros,
        string $carpetaStorage,
    ) {
        $this->afiliado = $afiliado;
        $this->parametros = $parametros;
        $this->carpetaStorage = $carpetaStorage;
    }

    /**
     * Execute the job.
     */
    public function handle(ConsultaRepository $consultaRepository, PdfService $pdfService): void
    {
        # consultamos el afiliado y sus consultas para las especialidades que pidieron
        $consultas = $consultaRepository->listarPorTipoYDocumento(
            $this->afiliado['documento'],
            $this->afiliado['tipo_documento'],
            $this->parametros['fecha_inicio'],
            $this->parametros['fecha_final'],
            isset($this->parametros['tipo_historia']) ? $this->parametros['tipo_historia'] : [],
            isset($this->parametros['especialidades']) ? $this->parametros['especialidades'] : [],
            isset($this->parametros['medico_id']) ? $this->parametros['medico_id'] : null
        );
        # creamos la carpeta del afiliado
        $carpetaAfiliado = TipoDocumentoEnum::valor(intval($this->afiliado['tipo_documento'])) . $this->afiliado['documento'];
        $ruta = $this->carpetaStorage . '/' . $carpetaAfiliado;
        mkdir($ruta, 0777, true);
        # si no hay resultados en la consulta no generamos nada
        if ($consultas->count() < 1) {
            touch($ruta . '/sin_consultas.txt');
            file_put_contents($ruta . '/sin_consultas.txt', 'Este archivo indica que no se encontraron consultas para el afiliado en el rango de fechas ' . $this->parametros['fecha_inicio'] . ' - ' . $this->parametros['fecha_final']);
            return;
        }
        touch($ruta . '/errores.txt');
        $historiasGeneradas = 0;
        foreach ($consultas as $consulta) {
            try {
                $obj = new HistoriaClinicaIntegralBase();
                // Genero la historia y la ruta
                $salida = $ruta . '/' . $consulta->id . '_' . uniqid() . '.pdf';
                $obj->generar($consulta, '', null, $salida);
                // Contador de historias generadas
                $historiasGeneradas++;
            } catch (\Throwable $th) {
                $error = sprintf(
                    "[%s] La consulta %d falló: %s%s",
                    date('Y-m-d H:i:s'),
                    $consulta->id,
                    $th->getMessage(),
                    PHP_EOL
                );
                file_put_contents($ruta . '/errores.txt', $error, FILE_APPEND);
                continue;
            } finally {
                $obj = null;
            }
        }

        # validacion si se lograron crear las historias
        if ($historiasGeneradas < 1) {
            throw new \Exception('No se generaron historias', 404);
        }
        # recuperamos las rutas de los archivos para generar un solo pdf
        $archivos = File::files($ruta);
        $nombreArchivos = collect($archivos)
            ->filter(function ($archivo) {
                return $archivo->getExtension() === 'pdf';
            })
            ->map(function ($archivo) use ($ruta) {
                return $ruta . '/' . $archivo->getFilename();
            })->toArray();
        $nombrePdfCombinado = $this->afiliado['documento'] . '_7Consolidado_' . Carbon::parse($this->parametros['fecha_corte'])->format('ymd') . '.pdf';
        $pdfService->combinarPDFs($nombreArchivos, $ruta . '/' . $nombrePdfCombinado);
        # Eliminamos los archivos y dejamos solo el combinado
        foreach ($nombreArchivos as $archivo) {
            if (file_exists($archivo)) {
                unlink($archivo);
            }
        }
    }
}
