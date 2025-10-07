<?php

namespace App\Http\Modules\Solicitudes\AdjuntosRadicacionOnline\Repositories;

use App\Http\Modules\Bases\RepositoryBase;
use App\Http\Modules\Solicitudes\AdjuntosRadicacionOnline\Models\AdjuntosRadicacionOnline;

class AdjuntosRadicacionOnlineRepository extends RepositoryBase{

    public function __construct(protected AdjuntosRadicacionOnline $adjuntosRadicacionOnlineModel){
        parent::__construct($this->adjuntosRadicacionOnlineModel);
    }

    public function crearAdjunto($nombre,$ruta,$radicado){
        $this->adjuntosRadicacionOnlineModel->create([
            'nombre' => $nombre,
            'ruta' => $ruta,
            'radicacion_online_id' => $radicado
        ]);

    }

    public function crearAdjuntoGestion($nombre,$ruta,$gestion){
        $this->adjuntosRadicacionOnlineModel->create([
            'nombre' => $nombre,
            'ruta' => $ruta,
            'gestion_radicacion_online_id' => $gestion
        ]);

    }



}
