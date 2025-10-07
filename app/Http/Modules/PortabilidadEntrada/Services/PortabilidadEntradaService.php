<?php

namespace App\Http\Modules\PortabilidadEntrada\Services;

use App\Http\Modules\AdjuntosPortabilidad\Models\AdjuntosPortabilidad;
use App\Traits\ArchivosTrait;

class PortabilidadEntradaService {

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
                    'portabilidad_salida_id'    =>null,
                    'portabilidad_entrada_id'   =>$id,
                ]);
            }
        }
       return $adjunto;


    }
}
