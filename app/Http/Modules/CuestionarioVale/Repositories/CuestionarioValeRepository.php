<?php

namespace App\Http\Modules\CuestionarioVale\Repositories;

use App\Http\Modules\Bases\RepositoryBase;
use App\Http\Modules\CuestionarioVale\Model\CuestionarioVale;

class CuestionarioValeRepository extends RepositoryBase {

    protected $cuestionarioVale;

    public function __construct(CuestionarioVale $cuestionarioVale)
    {
        $this->cuestionarioVale = $cuestionarioVale;
    }

    public function crearVale($data)
    {
        $this->cuestionarioVale::updateOrCreate(['consulta_id' => $data['consulta_id']], $data);
    }

    public function obtenerDatosporAfiliado($afiliadoId)
    {
        return $this->cuestionarioVale
            ->whereHas('consulta', function ($query) use ($afiliadoId) {
                $query->where('afiliado_id', $afiliadoId);
            })
            ->latest()
            ->first();
    }}
