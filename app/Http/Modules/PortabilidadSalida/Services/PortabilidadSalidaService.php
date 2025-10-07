<?php

namespace App\Http\Modules\PortabilidadSalida\Services;

use App\Http\Modules\AdjuntosPortabilidad\Models\AdjuntosPortabilidad;
use App\Traits\ArchivosTrait;

class PortabilidadSalidaService {

    use ArchivosTrait;


    public function guardarAdjunto($data, $id){
        $archivos = $data->file('adjuntos');
        $ruta = 'adjuntosPortabilidad';
        if(sizeof($archivos) >= 1){
            foreach($archivos as $archivo){
                $nombre = $archivo->getClientOriginalName();
                $subirArchivo = $this->subirArchivoNombre($ruta,$archivo,$nombre,'server37');
                $adjunto = AdjuntosPortabilidad::create([
                    'nombre'                    =>$nombre,
                    'ruta'                      =>$subirArchivo,
                    'portabilidad_salida_id'    =>$id,
                    'portabilidad_entrada_id'   =>null,
                ]);
            }
        }
       return $adjunto;


    }
}
