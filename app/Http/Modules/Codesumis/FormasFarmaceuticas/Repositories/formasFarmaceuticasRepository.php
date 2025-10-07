<?php

namespace App\Http\Modules\Codesumis\FormasFarmaceuticas\Repositories;

use App\Http\Modules\Bases\RepositoryBase;
use App\Http\Modules\Codesumis\FormasFarmaceuticas\Models\formasFarmaceuticas;

class formasFarmaceuticasRepository extends RepositoryBase
{
    protected $formasFarmaceuticas;

    public function __construct()
    {
        $this->formasFarmaceuticas = new formasFarmaceuticas();
        parent::__construct($this->formasFarmaceuticas);
    }

    public function listarFormas()
    {
        return $this->formasFarmaceuticas->select(
            'formas_farmaceuticas.id',
            'formas_farmaceuticas.nombre'
        )
            ->get();
    }
    public function actualizarForma($id, array $data)
    {
        $forma = $this->formasFarmaceuticas->find($id);

        if (!$forma) {
            throw new \Exception("La forma Farmaceutica no existe");
        }

        $forma->update($data);
        return $forma;
    }
}
