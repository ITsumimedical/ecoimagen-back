<?php

namespace App\Http\Modules\TipoSolicitudBodegas\Repositories;

use App\Http\Modules\Bases\RepositoryBase;
use App\Http\Modules\TipoSolicitudBodegas\Models\TipoSolicitudBodega;

class TipoSolicitudBodegasRepository extends RepositoryBase {

    private $tipoSolicitudBodegaModel;

    public function __construct() {
        $this->tipoSolicitudBodegaModel = new TipoSolicitudBodega();
        parent::__construct($this->tipoSolicitudBodegaModel);
    }

    public function listar($data)
    {
        /** Definimos el orden*/
        $orden = isset($data->orden) ? $data->orden : 'desc';
        if($data->page){
            $filas = $data->filas ? $data->filas : 10;
            return $this->model
                ->orderBy('created_at', $orden)
                ->whereTipo($data->tipo)
                ->paginate($filas);
        }else{
            return $this->model
                ->orderBy('created_at', $orden)
                ->whereTipo($data->tipo)
                ->get();
        }
    }
}
