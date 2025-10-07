<?php

namespace App\Http\Modules\Historia\EscalaAbreviadaDesarrollos\Repositories;

use App\Http\Modules\Bases\RepositoryBase;
use App\Http\Modules\Historia\EscalaAbreviadaDesarrollos\Models\ConversionPdPt;
use App\Http\Modules\Historia\EscalaAbreviadaDesarrollos\Models\RegistroEscalaAbreviadaDesarrollo;

class EscalaAbreviadaRepository extends RepositoryBase
{

    public function __construct()
    {
        parent::__construct(new RegistroEscalaAbreviadaDesarrollo());
    }

    public function listarEscalaAbreviada($afiliadoId)
    {
        $afiliadoId = $afiliadoId->input('afiliado_id');

        return $this->model->whereHas('consulta', function ($query) use ($afiliadoId) {
            $query->where('afiliado_id', $afiliadoId);
        })->get();
    }

    public function convertirPd($request)
    {
        $tipoEscalaId = $request['tipoEscala'];
        $puntuacionDirecta = $request['puntuacion_directa'];
        $rango = $request['rango'];

        return ConversionPdPt::where('tipo_escala_abreviada_id', $tipoEscalaId)
            ->where('puntuacion_directa', $puntuacionDirecta)
            ->where('rango', $rango)
            ->get();
    }

}
