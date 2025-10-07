<?php

namespace App\Http\Modules\Empalme\Adjunto\Repositories;

use App\Http\Modules\Bases\RepositoryBase;
use App\Http\Modules\Empalme\Adjunto\Model\AdjuntoEmpalme;

class AdjuntoEmpalmeRepository extends RepositoryBase
{
    protected $adjuntoEmpalmeModel;

    public function __construct()
    {
        $this->adjuntoEmpalmeModel = new AdjuntoEmpalme();
        parent::__construct($this->adjuntoEmpalmeModel);
    }

    public function crearAdjunto($empalme_id, $nombre, $ruta)
    {
        $this->adjuntoEmpalmeModel->create([
            'empalme_id' => $empalme_id,
            'nombre' => $nombre,
            'ruta' => $ruta
        ]);
    }
}
