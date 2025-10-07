<?php

namespace App\Http\Modules\TratamientosBiologicos\Repositories;

use App\Http\Modules\Bases\RepositoryBase;
use App\Http\Modules\TratamientosBiologicos\Model\TratamientosBiologicos;

class TratamientosBiologicosRepository extends RepositoryBase {

     public function __construct(protected TratamientosBiologicos $tratamientosBiologicos)
    {
        parent::__construct($this->tratamientosBiologicos);
    }

    public function listarTratamientosPorAfiliado(int $afiliado_id)
    {
        return $this->tratamientosBiologicos::with('usuarioRegistra:id', 'usuarioRegistra.operador:user_id,nombre,apellido')
        ->whereHas('consulta.afiliado', function ($query) use ($afiliado_id) {
                $query->where('id', $afiliado_id);
            })
            ->get();
    }
}
