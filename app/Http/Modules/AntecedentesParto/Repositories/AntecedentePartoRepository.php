<?php

namespace App\Http\Modules\AntecedentesParto\Repositories;

use App\Http\Modules\AntecedentesParto\Model\AntecedenteParto;
use App\Http\Modules\Bases\RepositoryBase;

class AntecedentePartoRepository extends RepositoryBase {

    public function __construct(protected AntecedenteParto $antecedenteParto)
    {
        parent::__construct($this->antecedenteParto);
    }

    public function crearParto(array $data)
    {
        return $this->antecedenteParto->updateOrCreate(
            ['consulta_id' => $data['consulta_id']],
            $data
        );
    }

    public function ListarHistoricoId() {

    }



    public function ListarHistorico($afiliado_id)
    {
        return $this->antecedenteParto->with(['consulta.afiliado', 'creadoPor.operador:nombre,apellido,user_id'])
               ->whereHas('consulta', function ($query) use ($afiliado_id) {
                $query->where('afiliado_id', $afiliado_id);
            })->get();
    }
}
