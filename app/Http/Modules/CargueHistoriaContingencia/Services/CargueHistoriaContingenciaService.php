<?php

namespace App\Http\Modules\CargueHistoriaContingencia\Services;

use App\Http\Modules\CargueHistoriaContingencia\Repositories\CargueHistoriaContingenciaRepository;
use App\Http\Modules\Consultas\Repositories\ConsultaRepository;
use App\Http\Modules\Historia\Models\HistoriaClinica;
use App\Traits\ArchivosTrait;
use Illuminate\Support\Str;


class CargueHistoriaContingenciaService
{

    use ArchivosTrait;

    public function __construct(private ConsultaRepository $consultaRepository, private CargueHistoriaContingenciaRepository $cargueHistoriaContingenciaRepository) {}

    public function guardar($data)
    {
        $consulta = $this->consultaRepository->crearConsultaContingencia($data);
        HistoriaClinica::create(['consulta_id' => $consulta->id]);

        if (isset($data['cie10_id'])) {
            $consulta->cie10Afiliado()->create([
                'cie10_id' => $data['cie10_id'],
                'esprimario' => true, // Columna adicional
                'tipo_diagnostico' => 'Impresión diagnóstica', // Columna adicional
                'consulta_id' => $consulta->id,
            ]);
        }

        // Guardamos los archivos adjuntos
        if (isset($data['adjuntos'])) {
            $archivo = $data['adjuntos'];
            $ruta = 'anexo_pacientes';
            $nombreOriginal = Str::uuid() . '.' . $archivo->getClientOriginalExtension();
            $subirArchivo = $this->subirArchivoNombre($ruta, $archivo, $nombreOriginal, 'server37');
            $this->cargueHistoriaContingenciaRepository->crearCargue($subirArchivo, $nombreOriginal, $consulta->id, $data['tipo_archivo_id'], $data['fecha_proceso'], auth()->user()->id);
        }

        return $consulta;
    }
}
