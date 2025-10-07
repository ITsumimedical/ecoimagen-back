<?php

namespace App\Http\Modules\GestionOrdenPrestador\Repositories;

use App\Http\Modules\Bases\RepositoryBase;
use App\Http\Modules\GestionOrdenPrestador\Models\AdjuntosGestionOrden;

class AdjuntoGestionOrdenRepository extends RepositoryBase
{
    protected $adjuntoGestionOrdenModel;

    public function __construct()
    {
        $this->adjuntoGestionOrdenModel = new AdjuntosGestionOrden();
        parent::__construct($this->adjuntoGestionOrdenModel);
    }
}