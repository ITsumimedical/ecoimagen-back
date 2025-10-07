<?php

namespace App\Http\Modules\TipoRCVCaracterizacion\Repositories;
use App\Http\Modules\Bases\RepositoryBase;
use App\Http\Modules\TipoRCVCaracterizacion\Models\TipoRCVCaracterizacion;

class TipoRCVCaracterizacionRepository extends RepositoryBase
{
    protected $tipoRCVModel;
    public function __construct()
    {
        $this->tipoRCVModel = new TipoRCVCaracterizacion();
        parent::__construct($this->tipoRCVModel);
    }

    public function listarTodas()
    {
        return $this->tipoRCVModel->all();
    }
}