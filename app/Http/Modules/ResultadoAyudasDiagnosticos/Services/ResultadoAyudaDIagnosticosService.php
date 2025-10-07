<?php

namespace App\Http\Modules\ResultadoAyudasDiagnosticos\Services;

use App\Http\Modules\AdjuntosAyudasDiagnosticos\Services\AdjuntosAyudasDiagnosticosService;
use App\Http\Modules\AdjuntosResultadosAyudasDiagnosticos\Services\AdjuntosResultadosAyudasDiagnosticosService;
use App\Http\Modules\ResultadoAyudasDiagnosticos\Repositories\ResultadoAyudasDiagnosticasRepository;
use App\Traits\ArchivosTrait;
use Illuminate\Support\Str;


class ResultadoAyudaDIagnosticosService
{
    use ArchivosTrait;

    public function __construct(protected  ResultadoAyudasDiagnosticasRepository $resultadoAyudasDiagnosticasRepository, protected AdjuntosAyudasDiagnosticosService $adjuntosAyudasDiagnosticosService) {}

    public function guardarAyudasDiagnosticos($data)
    {
        $guardarAyudasDiagnosticas = $this->resultadoAyudasDiagnosticasRepository->crear($data);
        if (isset($data['adjuntos'])) {
            $ruta = 'adjuntosAyudasDiagnosticas';
            $archivos = $data['adjuntos'];
            if ($archivos && is_array($archivos)) {
                foreach ($archivos as $archivo) {
                    $nombre = $archivo->getClientOriginalName();
                    $uuid = Str::uuid();
                    $nombreUnicoAdjunto = $uuid . '.' . $nombre;
                    $subirArchivo = $this->subirArchivoNombre($ruta, $archivo, $nombreUnicoAdjunto, 'server37');

                    $adjunto = $this->adjuntosAyudasDiagnosticosService->crearAdjunto([
                        'nombre' => $nombre,
                        'ruta' => $subirArchivo,
                        'resultado_ayudas_diagnosticas_id' => $guardarAyudasDiagnosticas->id
                    ]);
                }
                return (object)[
                    'resultado_ayudas_diagnosticas' => $guardarAyudasDiagnosticas,
                    'adjunto' => $adjunto
                ];
            }
        }
    }

}
