<?php

namespace App\Http\Modules\Esquemas\Repositories;

use App\Http\Modules\Bases\RepositoryBase;
use App\Http\Modules\Esquemas\Models\Esquema;

class EsquemaRepository extends RepositoryBase
{

    public function __construct(protected Esquema $esquemaModel)
    {
        parent::__construct($this->esquemaModel);
    }

    public function listarEsquema(){
        return $this->esquemaModel::with([
            'detalleEsquema' => function ($query){
                $query->select(
                    'detalle_esquemas.*',
                    'codesumis.nombre'
                )
                    ->join('codesumis', 'detalle_esquemas.codesumi_id', 'codesumis.id')
                    ->get();
            }
        ])->get();
    }


}
