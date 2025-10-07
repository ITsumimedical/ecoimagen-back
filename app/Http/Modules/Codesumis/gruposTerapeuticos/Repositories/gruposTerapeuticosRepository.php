<?php

namespace App\Http\Modules\Codesumis\gruposTerapeuticos\Repositories;

use App\Http\Modules\Bases\RepositoryBase;
use App\Http\Modules\Codesumis\gruposTerapeuticos\Models\gruposTerapeuticos;

class gruposTerapeuticosRepository extends RepositoryBase
{


    protected $gruposTerapeuticos;

    public function __construct()
    {
        $this->gruposTerapeuticos = new gruposTerapeuticos();
        parent::__construct($this->gruposTerapeuticos);
    }

    public function gruposTerapeuticos()
    {
        return $this->gruposTerapeuticos->select(
            'grupos_terapeuticos.id',
            'grupos_terapeuticos.nombre'
        )
            ->get();
    }

    public function actualizarGrupoTerapeutico($id, array $data)
    {
        $grupo = $this->gruposTerapeuticos->find($id);

        if (!$grupo) {
            throw new \Exception("El grupo Terapeutico no existe");
        }

        $grupo->update($data);
        return $grupo;
    }
}
