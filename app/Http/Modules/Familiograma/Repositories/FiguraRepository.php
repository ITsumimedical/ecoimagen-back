<?php

namespace App\Http\Modules\Familiograma\Repositories;

use App\Http\Modules\Bases\RepositoryBase;
use App\Http\Modules\Familiograma\Models\Figura;

class FiguraRepository extends RepositoryBase
{

    public function __construct(Figura $model)
    {
        $this->model = $model;
    }

    public function obtenerTodas()
    {
        return Figura::with(['relacionesOrigen.figuraDestino', 'relacionesDestino.figuraOrigen'])->get();
    }

    public function crear($data)
    {
        return Figura::create($data);
    }

    public function obtenerPorId($id)
    {
        return Figura::with(['relacionesOrigen.figuraDestino', 'relacionesDestino.figuraOrigen'])->findOrFail($id);
    }

    public function actualizar($id, $data)
    {
        $figura = Figura::findOrFail($id);
        $figura->update($data);
        return $figura;
    }

    public function eliminar($id)
    {
        $figura = Figura::findOrFail($id);
        $figura->delete();
        return true;
    }
}
