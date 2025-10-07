<?php

namespace App\Http\Modules\estructuraDinamica\Repositories;

use App\Http\Modules\Bases\RepositoryBase;
use App\Http\Modules\estructuraDinamica\Model\EstructuraDinamicaFamiliar;

class EstructuraDinamicaFamiliarRepository extends RepositoryBase
{

    public function __construct(protected EstructuraDinamicaFamiliar $estructuraDinamicaFamiliar)
    {
        parent::__construct($this->estructuraDinamicaFamiliar);
    }


    public function crearEstructura(array $data)
    {
        return $this->estructuraDinamicaFamiliar->updateOrCreate(
            ['consulta_id' => $data['consulta_id']],
            $data
        );
    }

}
