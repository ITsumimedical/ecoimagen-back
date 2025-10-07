<?php

namespace App\Http\Modules\AreaSolicitudes\Repositories;

use App\Http\Modules\AreaSolicitudes\Models\AreaSolicitudes;
use App\Http\Modules\Bases\RepositoryBase;


class AreaSolicitudesRepository extends RepositoryBase
{

    protected $CategoriaMesaAyudaModel;

    public function __construct(AreaSolicitudes $CategoriaMesaAyudaModel)
    {
        $this->CategoriaMesaAyudaModel = $CategoriaMesaAyudaModel;
        parent::__construct($this->CategoriaMesaAyudaModel);
    }

    /**
     * Listar categorias con su respectiva area
     *
     * @return void
     */


    public function listarArea()
    {
        return $this->CategoriaMesaAyudaModel::with('user.operador')
            ->get();
    }
}
