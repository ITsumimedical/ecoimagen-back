<?php

namespace App\Http\Modules\AntecedentesGestacion\Repositories;

use App\Http\Modules\AntecedentesGestacion\Models\AntecedentesGestacion;
use App\Http\Modules\Bases\RepositoryBase;

class AntecedeGestacionRepository extends RepositoryBase
{

    public function __construct(protected AntecedentesGestacion $antecedenteGestacion)
    {
        parent::__construct($this->antecedenteGestacion);
    }

    public function crearAntecedente(array $data)
    {
        return $this->antecedenteGestacion->updateOrCreate(
            ['consulta_id' => $data['consulta_id']],
            $data
        );
    }

    public function obtenerdatos($afiliadoId)
    {
        return $this->antecedenteGestacion->with(['consulta:id,afiliado_id', 'creadoPor.operador:nombre,apellido,user_id'])
        ->whereHas('consulta', function ($query) use ($afiliadoId) {
            $query->where('afiliado_id', $afiliadoId);
        })->get();
    }

    public function eliminarAyudaDiagnostica($id)
    {
        $resultado = $this->antecedenteGestacion->findOrFail($id);
        return $resultado->delete();
    }
}
