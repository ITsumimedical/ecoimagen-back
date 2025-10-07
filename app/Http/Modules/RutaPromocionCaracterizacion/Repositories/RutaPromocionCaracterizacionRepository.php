<?php

namespace App\Http\Modules\RutaPromocionCaracterizacion\Repositories;
use App\Http\Modules\Bases\RepositoryBase;
use App\Http\Modules\RutaPromocionCaracterizacion\Models\RutaPromocionCaracterizacion;

class RutaPromocionCaracterizacionRepository extends RepositoryBase
{

    protected $rutaPromocionModel;

    public function __construct()
    {
        $this->rutaPromocionModel = new RutaPromocionCaracterizacion();
        parent::__construct($this->rutaPromocionModel);
    }

    public function listarTodas()
    {
        return $this->rutaPromocionModel->all();
    }
}