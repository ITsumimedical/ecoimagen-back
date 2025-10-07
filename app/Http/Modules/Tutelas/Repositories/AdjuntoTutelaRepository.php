<?php

namespace App\Http\Modules\Tutelas\Repositories;

use App\Http\Modules\Bases\RepositoryBase;
use App\Http\Modules\Tutelas\Models\AdjuntoTutela;

class AdjuntoTutelaRepository extends RepositoryBase {

    public function __construct(protected AdjuntoTutela $adjuntosTutelas) {
        parent::__construct($this->adjuntosTutelas);
    }

    public function crearAdjunto($ruta, $nombre,$respuesta_id){
        return $this->adjuntosTutelas->create(['ruta' => $ruta,
                                                'nombre' => $nombre,
                                                'respuesta_id' => $respuesta_id]);
    }

    public function crearAdjuntoActuacion($ruta, $nombre,$actuacion){
        return $this->adjuntosTutelas->create(['ruta' => $ruta,
                                                'nombre' => $nombre,
                                                'actuacion_tutela_id' => $actuacion]);
    }
}
