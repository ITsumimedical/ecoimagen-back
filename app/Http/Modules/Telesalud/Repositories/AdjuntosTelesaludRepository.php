<?php

namespace App\Http\Modules\Telesalud\Repositories;

use App\Http\Modules\Bases\RepositoryBase;
use App\Http\Modules\Telesalud\Models\AdjuntosTelesalud;

class AdjuntosTelesaludRepository extends RepositoryBase
{
    protected $adjuntoTelesaludModel;


    public function __construct()
    {
        $this->adjuntoTelesaludModel = new AdjuntosTelesalud();
        parent::__construct($this->adjuntoTelesaludModel);
    }

    /**
     * Crea el registro del adjunto asociado a una gestión de telesalud
     * @param int $gestionTelesaludId
     * @param string $nombre
     * @param string $ruta
     * @return void
     */
    public function crearAdjunto($gestionTelesaludId, $nombre, $ruta)
    {
        $this->adjuntoTelesaludModel->create([
            'gestion_telesalud_id' => $gestionTelesaludId,
            'nombre' => $nombre,
            'ruta' => $ruta
        ]);
    }
}
