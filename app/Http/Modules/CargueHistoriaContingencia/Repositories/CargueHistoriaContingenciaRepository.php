<?php

namespace App\Http\Modules\CargueHistoriaContingencia\Repositories;

use App\Http\Modules\Bases\RepositoryBase;
use App\Http\Modules\CargueHistoriaContingencia\Models\CargueHistoriaContingencia;

class CargueHistoriaContingenciaRepository extends RepositoryBase
{

    public function __construct(protected CargueHistoriaContingencia $cargueHistoriaContingenciaModel)
    {
        parent::__construct($this->cargueHistoriaContingenciaModel);
    }

    public function crearCargue($ruta, $nombre, $consulta, $tipo, $fecha, $user)
    {
        return $this->cargueHistoriaContingenciaModel::create([
            'ruta' => $ruta,
            'nombre' => $nombre,
            'consulta_id' => $consulta,
            'tipo_archivo_id' => $tipo,
            'fecha_proceso' => $fecha,
            'funcionario_carga' => $user
        ]);
    }
}
