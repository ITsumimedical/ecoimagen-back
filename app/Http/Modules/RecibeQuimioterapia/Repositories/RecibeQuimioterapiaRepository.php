<?php

namespace App\Http\Modules\RecibeQuimioterapia\Repositories;

use App\Http\Modules\Bases\RepositoryBase;
use App\Http\Modules\RecibeQuimioterapia\Model\RecibeQuimioterapia;

class RecibeQuimioterapiaRepository extends RepositoryBase {

     public function __construct(protected RecibeQuimioterapia $recibeQuimioterapia)
    {
        parent::__construct($this->recibeQuimioterapia);
    }

    public function listarQuimioterapiasPorAfiliado($afiliado_id)
    {
        return $this->recibeQuimioterapia::with('usuarioRegistra:id', 'usuarioRegistra.operador:user_id,nombre,apellido')
         ->whereHas('consulta.afiliado', function ($query) use ($afiliado_id) {
                $query->where('id', $afiliado_id);
            })
            ->get();
    }
}
