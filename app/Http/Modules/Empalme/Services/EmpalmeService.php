<?php

namespace App\Http\Modules\Empalme\Services;

use App\Traits\ArchivosTrait;
use App\Http\Modules\Empalme\Models\Empalme;
use App\Http\Modules\Empalme\Adjunto\Repositories\AdjuntoEmpalmeRepository;
use App\Http\Modules\Empalme\Repositories\EmpalmeRepository;

class EmpalmeService
{
    use ArchivosTrait;

    public function __construct(
        private EmpalmeRepository $empalmeRepository,
        private AdjuntoEmpalmeRepository $adjuntoEmpalmeRepository,
    ) {
    }

    public function crear( $data)
    {
        $empalme = $this->empalmeRepository->crear($data);
        $archivos = $data['adjuntos'];
        $ruta = 'adjuntosEmpalme';
        if (sizeof($archivos) >= 1) {
            foreach ($archivos as $archivo) {
                $nombreOriginal = $archivo->getClientOriginalName();
                $nombre = $empalme->id . '/' . time() . $nombreOriginal;
                $subirArchivo = $this->subirArchivoNombre($ruta, $archivo, $nombre, 'server37');
                $this->adjuntoEmpalmeRepository->crearAdjunto($empalme->id, $nombreOriginal, $subirArchivo);
            }
        }
        return $empalme->id;
    }
}
