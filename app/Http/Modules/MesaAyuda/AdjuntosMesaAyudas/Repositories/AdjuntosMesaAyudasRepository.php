<?php

namespace App\Http\Modules\MesaAyuda\AdjuntosMesaAyudas\Repositories;

use App\Http\Modules\Bases\RepositoryBase;
use App\Http\Modules\MesaAyuda\AdjuntosMesaAyudas\Models\AdjuntosMesaAyudasModel;
use App\Traits\ArchivosTrait;

class AdjuntosMesaAyudasRepository extends RepositoryBase
{
    protected $AdjuntosMesaAyudasModel;
    use ArchivosTrait;

    public function __construct(AdjuntosMesaAyudasModel $AdjuntosMesaAyudasModel)
    {
        $this->AdjuntosMesaAyudasModel = $AdjuntosMesaAyudasModel;
        parent::__construct($this->AdjuntosMesaAyudasModel);
    }

    public function crearAdjunto($mesa_ayuda_id, $nombre, $ruta)
    {
        $this->AdjuntosMesaAyudasModel->create([
            'mesa_ayuda_id' => $mesa_ayuda_id,
            'nombre' => $nombre,
            'ruta' => $ruta
        ]);
    }

}
