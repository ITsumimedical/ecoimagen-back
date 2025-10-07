<?php

namespace App\Http\Modules\RespuestasTutelas\Services;

use App\Http\Modules\ActuacionTutelas\Models\actuacionTutelas;
use App\Http\Modules\RespuestasTutelas\Repositories\RespuestaTutelaRepository;
use App\Http\Modules\Tutelas\Models\AdjuntoTutela;
use App\Http\Modules\Tutelas\Repositories\AdjuntoTutelaRepository;
use App\Traits\ArchivosTrait;

class RespuestaTutelaService {

    use ArchivosTrait;
    public function __construct(protected RespuestaTutelaRepository $respuestaTutelaRepository, protected AdjuntoTutelaRepository $adjuntoTutelaRepository) {}

    public function guardarRespuesta($data) {
        // return $data;
        try{
        $respuesta = $this->respuestaTutelaRepository->crear($data);

        // si el tipo de respuesta es final se actualiza la actuacion
        // if($data['tipo_respuesta']== 'Final'){
        //   $actuacion =  actuacionTutelas::find($data['actuacion_tutela_id']);
        //   $actuacion->estado_id = 17;
        //   $actuacion->save();
        // }


        if (isset($data['adjuntos']) && sizeof($data['adjuntos']) >= 1){
            $archivos = $data['adjuntos'];
        $ruta = 'adjuntosRespuestaTutela';
         foreach($archivos as $archivo){
             $nombre = $archivo->getClientOriginalName();
             $subirArchivo = $this->subirArchivoNombre($ruta,$archivo,$nombre,'server37');

             $this->adjuntoTutelaRepository->crearAdjunto($subirArchivo,$nombre,$respuesta->id);
         }
        }
    }catch(\Throwable $th){
        return [
            'respuesta' => $respuesta,
            'mensaje' => $th->getMessage()
        ];
    }
}


}
