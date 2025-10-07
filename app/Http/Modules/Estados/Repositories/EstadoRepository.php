<?php

namespace App\Http\Modules\Estados\Repositories;

use App\Http\Modules\Bases\RepositoryBase;
use App\Http\Modules\Estados\Models\Estado;

class EstadoRepository extends RepositoryBase
{
    protected $estadoModel;

    public function __construct(Estado $estadoModel)
    {
        parent::__construct($estadoModel);
        $this->estadoModel = $estadoModel;
    }

}
