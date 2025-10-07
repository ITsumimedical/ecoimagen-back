<?php

namespace App\Http\Modules\CuentasMedicas\AdjuntoRelacionPago\Services;

use App\Http\Modules\CuentasMedicas\AdjuntoRelacionPago\Repositories\AdjuntoRelacionPagoRepository;
use App\Traits\ArchivosTrait;

class AdjuntoRelacionPagoServices{

    use ArchivosTrait;

 public function __construct( private AdjuntoRelacionPagoRepository $adjuntoRelacionPagoRepository) {}

 public function crearAdjuntoRelacionPago($data){
    $info= [];
    $archivos = $data['adjuntos'];
    $ruta = 'adjuntosRelacionPagos';
    if(sizeof($archivos) >= 1){
        foreach($archivos as $archivo){
            $nombreOriginal = $archivo->getClientOriginalName();
            $nombre = $data['prestador_id'] .'/'.time().'_'.$nombreOriginal;
            $subirArchivo = $this->subirArchivoNombre($ruta,$archivo,$nombre,'server37');
            $info['fecha'] = $data['fecha'];
            $info['prestador_id'] = $data['prestador_id'];
            $info['nombre'] = $nombreOriginal;
            $info['ruta']= $subirArchivo;
            $this->adjuntoRelacionPagoRepository->crearAdjunto($info);
        }
    }
    return 'Adjunto de pago cargado con exito!';
 }

}
