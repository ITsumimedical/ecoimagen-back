<?php

namespace App\Http\Modules\Codesumis\subgruposTerapeuticos\Repositories;

use App\Http\Modules\Bases\RepositoryBase;
use App\Http\Modules\Codesumis\subgruposTerapeuticos\Models\subgruposTerapeuticos;

class subgruposTerapeuticosRepository extends RepositoryBase
{


    protected $subgrupos;

    public function __construct()
    {
        $this->subgrupos = new subgruposTerapeuticos();
        parent::__construct($this->subgrupos);
    }

    public function listarsubgruposTerapeuticos()
    {
        return $this->subgrupos->select(
            'subgrupos_terapeuticos.id',
            'subgrupos_terapeuticos.nombre'
        )
            ->get();
    }

    public function actualizarSubgrupo($id, array $data)
    {
        $subgrupo = $this->subgrupos->find($id);

        if (!$subgrupo) {
            throw new \Exception("El subgrupo Terapeutico no existe");
        }

        $subgrupo->update($data);
        return $subgrupo;
    }
}
