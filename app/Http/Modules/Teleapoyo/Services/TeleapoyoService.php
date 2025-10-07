<?php

namespace App\Http\Modules\Teleapoyo\Services;

use App\Http\Modules\AdjuntoTeleapoyo\Models\AdjuntoTeleapoyo;
use App\Http\Modules\Afiliados\Repositories\AfiliadoRepository;
use App\Http\Modules\Cie10Afiliado\Repositories\Cie10AfiliadoRepository;
use App\Http\Modules\Consultas\Repositories\ConsultaRepository;
use App\Http\Modules\Teleapoyo\Models\Teleapoyo;
use App\Http\Modules\Teleapoyo\Repositories\TeleapoyoRepository;
use App\Traits\ArchivosTrait;
use Illuminate\Support\Facades\Auth;

class TeleapoyoService{

    protected $teleapoyoRepository;
    protected $afiliadoRepository;
    use ArchivosTrait;

    public function __construct(TeleapoyoRepository $teleapoyoRepository , AfiliadoRepository $afiliadoRepository,
                                private ConsultaRepository $consultaRepository,
                                private Cie10AfiliadoRepository $cie10AfiliadoRepository)
    {
        $this->teleapoyoRepository = $teleapoyoRepository;
        $this->afiliadoRepository = $afiliadoRepository;
    }

    public function guardarTeleapoyo($data){
        // Se crea la consulta
        $consulta = $this->consultaRepository->guardarConsultaParaTeleapoyo($data['afiliado_id']);

        // Preparamos la data
        $prueba = $this->prepararData($data, $consulta->id);

        // Guardamos el teleapoyo
        $teleapoyo = $this->teleapoyoRepository->crear($prueba);

        // Traemos la data del afiliado
        $afiliado = $this->afiliadoRepository->obtenerDatosAfiliado($data['numero_documento']);

        // Guardamos en la tabla intermedia los cie10
        $teleapoyo->cie10s()->attach($data['c10']);

        // Guardamos en la tabla de cie10 afiliados
        foreach($data['c10'] as $key => $cie10){
            $this->cie10AfiliadoRepository->crearCie10PacienteTeleapoyo($cie10, $consulta->id, $key);
        }

        // Guardamos los archivos adjuntos si existen
        if (isset($data['adjuntos']) && sizeof($data['adjuntos']) >= 1){
            $archivos = $data['adjuntos'];
            $ruta = 'storage/upload_teleconcepto';

            foreach($archivos as $archivo){
                $nombre = $archivo->getClientOriginalName();
                $subirArchivo = $this->subirArchivoNombre($ruta, $archivo, $nombre, 'server37');
                $teleapoyo->adjuntos()->save(new AdjuntoTeleapoyo(['ruta' => $subirArchivo]));
            }
        }

        return (Object) [
            'consulta' => $consulta->id,
            'teleapoyo' => $teleapoyo,
            'datosAfiliado' => $afiliado
        ];
    }


    public function prepararData($data,$consulta){

        $teleapoyo['afiliado_id'] = $data['afiliado_id'];
        $teleapoyo['especialidad_id'] = $data['especialidad_id'];
        $teleapoyo['girs'] = ($data['girs'] === 'true'?1:0);
        $teleapoyo['motivo_teleorientacion'] = $data['motivo_teleorientacion'];
        $teleapoyo['resumen_historia_clinica'] = $data['resumen_historia_clinica'];
        $teleapoyo['tipo_solicitudes_id'] = $data['tipo_solicitudes_id'];
        $teleapoyo['tipo_estrategia'] = $data['tipo_estrategia'];
        $teleapoyo['user_crea_id'] = Auth::id();
        $teleapoyo['estado_id'] = 10;
        $teleapoyo['consulta_id'] = $consulta;
        return $teleapoyo;
    }
}
