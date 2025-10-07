<?php

namespace App\Http\Modules\TipoArchivo\Repositories;

use App\Http\Modules\Bases\RepositoryBase;
use App\Http\Modules\TipoArchivo\Models\TipoArchivo;

class TipoArchivoRepository extends RepositoryBase {

    public function __construct(protected TipoArchivo $tipoArchivoModl) {
        parent::__construct($this->tipoArchivoModl);
    }





}
