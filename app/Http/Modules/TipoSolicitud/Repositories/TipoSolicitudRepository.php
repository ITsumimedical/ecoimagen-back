<?php

namespace App\Http\Modules\TipoSolicitud\Repositories;

use App\Http\Modules\Bases\RepositoryBase;
use App\Http\Modules\TipoSolicitud\Models\TipoSolicitude;

class TipoSolicitudRepository extends RepositoryBase {

    protected $tipoSolicitudModel;

    public function __construct()
    {
        $this->tipoSolicitudModel = new TipoSolicitude();
        parent::__construct($this->tipoSolicitudModel);
    }

    public function listarActivos($data)
    {
        $orden = isset($data->orden) ? $data->orden : 'desc';
        $filas = $data->filas ? $data->filas : 10;

        $consulta = $this->tipoSolicitudModel
            ->where('activo',true)
            ->orderBy('created_at', $orden);

        return $data->page ? $consulta->paginate($filas) : $consulta->get();
    }

}
