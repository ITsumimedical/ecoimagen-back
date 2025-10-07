<?php

namespace App\Http\Modules\AdjuntoSarlaft\Services;

use App\Http\Modules\AdjuntoSarlaft\Repositories\AdjuntoSarlaftRepository;
use App\Traits\ArchivosTrait;
use Illuminate\Support\Facades\Auth;

class AdjuntoSarlaftService{


    use ArchivosTrait;

    public function __construct( private AdjuntoSarlaftRepository $adjuntoSarlaftRepository)
    {

    }

    public function guardarAdjunto($data,$id){

        if($data['registroUnico']){
            $archivo = $data['registroUnico'];
               $ruta = 'storage/adjuntosSarlaft';
               $nombreOriginal = $archivo->getClientOriginalName();
               $nombre = $id .'/'.time().'_'.$nombreOriginal;
               $subirArchivo = $this->subirArchivoNombre($ruta,$archivo,$nombre,'server37');
               $this->adjuntoSarlaftRepository->crearAdjunto($subirArchivo,$nombreOriginal,$id);
        }

        if($data['cedualRepresentante']){
            $archivo = $data['cedualRepresentante'];
               $ruta = 'storage/adjuntosSarlaft';
               $nombreOriginal = $archivo->getClientOriginalName();
               $nombre = $id .'/'.time().'_'.$nombreOriginal;
               $subirArchivo = $this->subirArchivoNombre($ruta,$archivo,$nombre,'server37');
               $this->adjuntoSarlaftRepository->crearAdjunto($subirArchivo,$nombreOriginal,$id);
        }

        if($data['certificadoRepresentacion']){
            $archivo = $data['certificadoRepresentacion'];
               $ruta = 'storage/adjuntosSarlaft';
               $nombreOriginal = $archivo->getClientOriginalName();
               $nombre = $id .'/'.time().'_'.$nombreOriginal;
               $subirArchivo = $this->subirArchivoNombre($ruta,$archivo,$nombre,'server37');
               $this->adjuntoSarlaftRepository->crearAdjunto($subirArchivo,$nombreOriginal,$id);
        }

        if($data['decretoPosesion']){
            $archivo = $data['decretoPosesion'];
               $ruta = 'storage/adjuntosSarlaft';
               $nombreOriginal = $archivo->getClientOriginalName();
               $nombre = $id .'/'.time().'_'.$nombreOriginal;
               $subirArchivo = $this->subirArchivoNombre($ruta,$archivo,$nombre,'server37');
               $this->adjuntoSarlaftRepository->crearAdjunto($subirArchivo,$nombreOriginal,$id);
        }

        if($data['certificacionBancaria']){
            $archivo = $data['certificacionBancaria'];
               $ruta = 'storage/adjuntosSarlaft';
               $nombreOriginal = $archivo->getClientOriginalName();
               $nombre = $id .'/'.time().'_'.$nombreOriginal;
               $subirArchivo = $this->subirArchivoNombre($ruta,$archivo,$nombre,'server37');
               $this->adjuntoSarlaftRepository->crearAdjunto($subirArchivo,$nombreOriginal,$id);
        }

        if($data['formatoDiligenciado']){
            $archivo = $data['formatoDiligenciado'];
               $ruta = 'storage/adjuntosSarlaft';
               $nombreOriginal = $archivo->getClientOriginalName();
               $nombre = $id .'/'.time().'_'.$nombreOriginal;
               $subirArchivo = $this->subirArchivoNombre($ruta,$archivo,$nombre,'server37');
               $this->adjuntoSarlaftRepository->crearAdjunto($subirArchivo,$nombreOriginal,$id);
        }
        return 'OK';

    }


}
