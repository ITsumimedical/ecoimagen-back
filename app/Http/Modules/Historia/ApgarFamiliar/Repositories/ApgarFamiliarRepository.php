<?php

namespace App\Http\Modules\Historia\ApgarFamiliar\Repositories;

use App\Http\Modules\Bases\RepositoryBase;
use App\Http\Modules\Historia\ApgarFamiliar\Models\ApgarFamiliar;

class ApgarFamiliarRepository extends RepositoryBase {

    public function __construct(protected ApgarFamiliar $apgarModel) {
        parent::__construct($this->apgarModel);
    }

    public function listarApgar($data) {
        return $this->apgarModel::with('consulta','user')->whereHas('consulta.afiliado', function ($q) use ($data) {
            $q->where('afiliados.id', $data->afiliado);
        })->get();
    }

    public function crearApgar($data){
        $this->apgarModel::updateOrCreate(['consulta_id' => $data['consulta_id']],$data);
    }

    public function obtenerDatosApgar($afiliadoId)
    {
        $datos = $this->apgarModel::select('ayuda_familia', 'familia_habla_con_usted', 'cosas_nuevas', 'le_gusta_familia_hace', 'le_gusta_familia_comparte',
                                                  'resultado')
            ->whereHas('consulta', function ($query) use ($afiliadoId) {
                $query->where('afiliado_id', $afiliadoId);
            })
            ->latest()
            ->first();
        return $datos;
    }
}
