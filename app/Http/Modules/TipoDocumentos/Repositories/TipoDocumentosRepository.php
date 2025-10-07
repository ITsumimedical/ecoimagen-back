<?php

namespace App\Http\Modules\TipoDocumentos\Repositories;

use App\Http\Modules\Bases\RepositoryBase;
use App\Http\Modules\TipoDocumentos\Models\TipoDocumento;

class TipoDocumentosRepository extends RepositoryBase
{
    protected $tipoDocumentoModel;

    public function __construct() {
        $this->tipoDocumentoModel = new TipoDocumento();
        parent::__construct($this->tipoDocumentoModel);
    }

    public function listarTodas($data){
        /** Definimos el orden*/
        $orden = isset($data->orden) ? $data->orden : 'asc';
        $filas = $data->filas ? $data->filas : 10;

        $consulta = $this->model
            ->orderBy('created_at', $orden);

        return $data->page ? $consulta->paginate($filas) : $consulta->get();
    }

}
