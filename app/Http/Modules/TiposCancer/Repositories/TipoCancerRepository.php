<?php

namespace App\Http\Modules\TiposCancer\Repositories;

use App\Http\Modules\Bases\RepositoryBase;
use App\Http\Modules\TiposCancer\Model\TipoCancer;

class TipoCancerRepository extends RepositoryBase
{
    public function __construct(protected TipoCancer $tipoCancer)
    {
        parent::__construct($this->tipoCancer);
    }

    public function listarCie10TipoCancer(int $id)
    {
        $cancer = $this->tipoCancer::findOrFail($id);
        return $cancer->cie10s;
    }

    public function obtenerTipoCancerPorCie10(int $cie10_id)
    {
        return $this->tipoCancer::whereHas('cie10s', function ($query) use ($cie10_id) {
            $query->where('cie10_id', $cie10_id);
        })->first();
    }
}
