<?php

namespace App\Http\Modules\DemandaInsatisfecha\Repositories;

use App\Http\Modules\Bases\RepositoryBase;
use App\Http\Modules\DemandaInsatisfecha\Models\DemandaInsatisfecha;
use Illuminate\Support\Facades\Auth;

class DemandaInsatisfechaRepository extends RepositoryBase
{
    protected $Model;

    public function __construct()
    {
        $this->Model = new DemandaInsatisfecha;
        parent::__construct($this->Model);
    }

    public function crearInsatisfecha($data){
        $data['user_id'] = Auth::id();
        $data['estado_id'] = 1;

        return $data;
    }

    public function listarDemandaInsatisfecha($afiliado_id){
        $consulta = $this->model
            ->with('especialidad','cita','usuario.operador')
            ->whereAfiliadoId($afiliado_id)
            ->whereNull('consulta_id');

        return $consulta->get();
    }

}
