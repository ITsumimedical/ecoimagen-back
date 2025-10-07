<?php

namespace App\Http\Modules\Transcripciones\Transcripcion\Services;

use App\Http\Modules\Cie10Afiliado\Repositories\Cie10AfiliadoRepository;
use App\Http\Modules\Consultas\Repositories\ConsultaRepository;
use App\Traits\ArchivosTrait;
use App\Http\Modules\Transcripciones\Adjunto\Repositories\AdjuntoTranscripcionRepository;
use App\Http\Modules\Transcripciones\Transcripcion\Repositories\TranscripcionRepository;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class TranscripcionService
{

    use ArchivosTrait;

    public function __construct(
        protected TranscripcionRepository $transcripcionRepository,
        protected ConsultaRepository $consultaRepository,
        protected AdjuntoTranscripcionRepository $adjuntoTranscripcionRepository,
        protected Cie10AfiliadoRepository $cie10AfiliadoRepository
    ) {}

    public function guardarTranscripcion($data)
    {
        $data['tipo_consulta_id'] = 1;
        if ($data['tipo_transcripcion'] == 'Interna') {
            $data['medico_ordena_id'] = $data['medico_ordeno'];
        } else {
            $data['medico_ordena_id'] = auth()->user()->id;
        }

        $consulta = $this->consultaRepository->crear($data);

        $transcripcionPreparada = $this->prepararData($data, $consulta->id);
        $transcripcionCreada = $this->transcripcionRepository->crear($transcripcionPreparada);
        if ($data['tipo_transcripcion'] == 'Interna') {
            $data['medico_ordena_id'] = $transcripcionCreada->medico_ordeno;
        }
        $transcripcionCreada->cie10s()->attach($data['c10']);
        $this->cie10AfiliadoRepository->crearCie10Paciente($data['c10'], $consulta->id, 1);
        $archivos = $data['adjuntos'];
        $ruta = 'adjuntosTranscripcion';
        if (sizeof($archivos) >= 1) {
            foreach ($archivos as $archivo) {
                $nombre = $archivo->getClientOriginalName();
                $uuid = Str::uuid();
                $nombreUnicoAdjunto = $uuid . '.' . $nombre;
                $subirArchivo = $this->subirArchivoNombre($ruta, $archivo, $nombreUnicoAdjunto, 'server37');

                $adjunto = $this->adjuntoTranscripcionRepository->crear([
                    'nombre' => $nombre,
                    'ruta' => $subirArchivo,
                    'consulta_id' => $consulta->id
                ]);
            }

            return (object)[
                'transcripcion' => $transcripcionCreada,
                'consulta' => $consulta,
                'adjunto' => $adjunto
            ];
        }
    }

    public function prepararData($data, $consulta)
    {
        $transcripcionCreada['afiliado_id'] = $data['afiliado_id'];
        $transcripcionCreada['ambito'] = $data['ambito'];
        $transcripcionCreada['nombre_medico_ordeno'] = $data['nombre_medico_ordeno'];
        $transcripcionCreada['documento_medico_ordeno'] = $data['documento_medico_ordeno'];
        $transcripcionCreada['medico_ordeno'] = $data['medico_ordeno'];
        $transcripcionCreada['finalidad'] = $data['finalidad'];
        $transcripcionCreada['observaciones'] = $data['observaciones'];
        $transcripcionCreada['tipo_transcripcion'] = $data['tipo_transcripcion'];
        $transcripcionCreada['consulta_id'] = $consulta;

        if ($data['tipo_transcripcion'] === 'Interna') {
            $transcripcionCreada['sede_id'] = $data['sede_id'];
        } else {
            $transcripcionCreada['prestador_id'] = $data['prestador_id'];
        }

        return $transcripcionCreada;
    }
}
