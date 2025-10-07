<?php

namespace App\Http\Modules\Tanner\Repositories;

use App\Http\Modules\Bases\RepositoryBase;
use App\Http\Modules\Tanner\Model\EscalaTanner;

class EscalaTannerRepository extends RepositoryBase {

    public function __construct(protected EscalaTanner $tanner)
    {
        parent::__construct($this->tanner);
    }
    public function crearTanner(array $data)
    {
        return $this->tanner->updateOrCreate(['consulta_id' => $data['consulta_id']],$data);
    }
    public function obtenerDatos($afiliadoId)
    {
        return $this->tanner->select('mamario_mujeres', 'pubiano_mujeres', 'genital_hombres', 'pubiano_hombres')
        ->whereHas('consulta', function ($query) use ($afiliadoId) {
            $query->where('afiliado_id', $afiliadoId);
        })
        ->latest()
        ->first();
    }
}
