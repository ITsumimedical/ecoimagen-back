<?php

namespace App\Http\Modules\ModalidadGrupoTecSal\Repositories;

use App\Http\Modules\Bases\RepositoryBase;
use App\Http\Modules\ModalidadGrupoTecSal\Model\modalidadGrupoTecSal;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class modalidadGrupoTecSalRepository extends RepositoryBase
{

    public function __construct(protected modalidadGrupoTecSal $modalidadGrupoTecsal)
    {
        parent::__construct($this->modalidadGrupoTecsal);
    }


    public function update(int $id, array $data)
    {
        $modalidad = $this->modalidadGrupoTecsal->findOrFail($id);
        $modalidad->update($data);
    }
}
