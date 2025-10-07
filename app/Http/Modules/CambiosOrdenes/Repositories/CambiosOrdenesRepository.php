<?php

namespace App\Http\Modules\CambiosOrdenes\Repositories;

use App\Http\Modules\Bases\RepositoryBase;
use App\Http\Modules\CambiosOrdenes\Models\CambiosOrdene;

class CambiosOrdenesRepository extends RepositoryBase
{
    protected CambiosOrdene $cambiosOrdeneModel;

    public function __construct()
    {
        parent::__construct($this->cambiosOrdeneModel = new CambiosOrdene());
    }
}
