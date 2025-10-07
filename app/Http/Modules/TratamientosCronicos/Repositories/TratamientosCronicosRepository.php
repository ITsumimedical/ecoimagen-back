<?php

namespace App\Http\Modules\TratamientosCronicos\Repositories;

use App\Http\Modules\Bases\RepositoryBase;
use App\Http\Modules\TratamientosCronicos\Model\TratamientosCronicos;

class TratamientosCronicosRepository extends RepositoryBase {

    public function __construct(protected TratamientosCronicos $tratamientosCronicos)
    {
        parent::__construct($this->tratamientosCronicos);
    }


    public function listarTratamientosPorAfiliado(int $afiliado_id)
    {
        return $this->tratamientosCronicos::with('usuarioCreacion:id', 'usuarioCreacion.operador:user_id,nombre,apellido')
            ->whereHas('consulta.afiliado', function ($query) use ($afiliado_id) {
                $query->where('id', $afiliado_id);
            })
            ->get();
    }
}
