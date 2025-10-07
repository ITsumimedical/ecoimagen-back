<?php

namespace App\Http\Modules\EtiquetasTH\Repositories;

use App\Http\Modules\Bases\RepositoryBase;
use App\Http\Modules\EtiquetasTH\Models\EtiquetaTh;

class EtiquetaThRepository extends RepositoryBase {

    protected $etiquetaThModel;

    public function __construct() {
        $this->etiquetaThModel = new EtiquetaTh();
        parent::__construct($this->etiquetaThModel);
    }

}
