<?php

namespace App\Http\Modules\NovedadesAfiliados\Repositories;

use App\Http\Modules\Bases\RepositoryBase;
use App\Http\Modules\NovedadesAfiliados\Models\AdjuntosNovedadAfiliados;

class AdjuntosNovedadAfiliadosRepository extends RepositoryBase
{
    public function __construct(
        protected AdjuntosNovedadAfiliados $adjuntosNovedadAfiliadosModel
    ) {
        parent::__construct($this->adjuntosNovedadAfiliadosModel);
    }

    public function crearAdjunto($nombre, $ruta, $novedadId)
    {
        $this->adjuntosNovedadAfiliadosModel->create([
            'nombre' => $nombre,
            'ruta' => $ruta,
            'novedad_afiliado_id' => $novedadId
        ]);
    }
}
