<?php

namespace App\Http\Modules\Oncologia\TomaProcedimiento\Services;

use App\Traits\ArchivosTrait;
use App\Http\Modules\Afiliados\Models\Afiliado;
use App\Http\Modules\Consultas\Repositories\ConsultaRepository;
use App\Http\Modules\Oncologia\AdjuntosOncologicos\Repositories\AdjuntoOncologicoRepository;
use app\Http\Modules\Oncologia\TomaProcedimiento\Repositories\TomaProcedimientoRepository;

class TomaMuestraService {

    use ArchivosTrait;

    public function __construct(protected TomaProcedimientoRepository $tomaProcedimientoRepository,
                                protected ConsultaRepository $consultaRepository,
                                protected AdjuntoOncologicoRepository $adjuntoOncologicoRepository)
    {

    }
    public function registrar($data){
        if ($data['tipo_radicacion'] === 'CARGA DE RESULTADOS') {
            $afiliado_id = Afiliado::where('numero_documento', $data['cedula_paciente'])->first();
            $data['afiliado_id'] = $afiliado_id->id;
            $data['finalidad'] = 'Consulta para ordenar muestras oncologícas';
            $data['tipo_consulta_id'] = 87;
            $data['registrado_por_id'] = auth()->id();
            $data['medico_ordena_id'] = auth()->id();
            $consulta = $this->consultaRepository->crear($data);
            $data['consulta_id'] = $consulta->id;
            $procedimiento = $this->tomaProcedimientoRepository->crear($data);
            $archivos = $data['adjuntos'];
            $ruta = 'adjuntosOncologicos';
            if(sizeof($archivos) >= 1){
                foreach($archivos as $archivo){
                    $nombre = $archivo->getClientOriginalName();
                    $subirArchivo = $this->subirArchivoNombre($ruta,$archivo,$nombre,'server37');
                    $adjunto = $this->adjuntoOncologicoRepository->crear(['nombre'=>$nombre,
                    'ruta'=>$subirArchivo,
                    'toma_procedimiento_id' => $procedimiento->id]);
                }
                return (object)[
                    'procedimiento' => $procedimiento,
                    'consulta' => $consulta,
                    'adjunto' => $adjunto
                ];

            }

        }else {
            $afiliado_id = Afiliado::where('numero_documento', $data['cedula_paciente'])->first();
            $data['afiliado_id'] = $afiliado_id->id;
            $data['registrado_por_id'] = auth()->id();
            $procedimiento = $this->tomaProcedimientoRepository->crear($data);
            $archivos = $data['adjuntos'];
            $ruta = 'adjuntosOncologicos';
            if(sizeof($archivos) >= 1){
                foreach($archivos as $archivo){
                    $nombre = $archivo->getClientOriginalName();
                    $subirArchivo = $this->subirArchivoNombre($ruta,$archivo,$nombre,'server37');
                    $adjunto = $this->adjuntoOncologicoRepository->crear(['nombre'=>$nombre,
                    'ruta'=>$subirArchivo,
                    'toma_procedimiento_id' => $procedimiento->id]);
                }
                return (object)[
                    'procedimiento' => $procedimiento,
                    'adjunto' => $adjunto
                ];

            }
        }
    }
}
