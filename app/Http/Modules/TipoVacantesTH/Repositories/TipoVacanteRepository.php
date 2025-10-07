<?php

namespace App\Http\Modules\TipoVacantesTH\Repositories;

use App\Http\Modules\Bases\RepositoryBase;
use App\Http\Modules\TipoVacantesTH\Models\TipoVacanteTh;
use Illuminate\Http\Request;

class TipoVacanteRepository extends RepositoryBase {

    private $tipoVacanteModel;

    public function __construct(TipoVacanteTh $tipoVacanteModel)
    {
        parent::__construct($tipoVacanteModel);
        $this->tipoVacanteModel = $tipoVacanteModel;
    }

    public function listar($request)
    {
        return $this->tipoVacanteModel->select([
            'tipo_vacante_ths.id', 'tipo_vacante_ths.nombre', 'tipo_vacante_ths.descripcion',
            'estados.nombre as nombreEstado', 'estados.id as estadoId'
        ])->join('estados', 'tipo_vacante_ths.estado_id', 'estados.id')
            ->when(!is_null($request['filtro']), function ($filter) use ($request) {
            $filter->where('tipo_vacante_ths.nombre', 'ILIKE', '%' . $request['filtro'] . '%')
            ->orWhere('tipo_vacante_ths.descripcion', 'ILIKE', '%' . $request['filtro'] . '%')
            ->orWhere('estados.nombre', 'ILIKE', '%' . $request['filtro'] . '%');
        })
        ->where('tipo_vacante_ths.estado_id', 1)
        ->orderBy('tipo_vacante_ths.created_at', 'desc')
        ->paginate(5);
    }
}
