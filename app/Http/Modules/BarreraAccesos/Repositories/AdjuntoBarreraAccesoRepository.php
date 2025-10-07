<?php

namespace App\Http\Modules\BarreraAccesos\Repositories;

use App\Http\Modules\BarreraAccesos\Models\AdjuntoBarreraAcceso;
use App\Http\Modules\Bases\RepositoryBase;

class AdjuntoBarreraAccesoRepository extends RepositoryBase {

    public function __construct(protected AdjuntoBarreraAcceso $adjuntoBarreraAcceso)
    {}

    /**
     * Crear adjuntos (Evidencia de las barreras de acceso)
     * @param $barrera_id
     * @param $nombre
     * @param $ruta
     * @author Sofia O
     */
     public function crearAdjunto($barrera_id,$nombre,$ruta)
    {
        $this->adjuntoBarreraAcceso->create([
            'barrera_id' => $barrera_id,
            'nombre' => $nombre,
            'ruta' => $ruta
        ]);
    }
}
