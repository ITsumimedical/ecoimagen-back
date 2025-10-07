<?php

namespace App\Http\Modules\Ecomapa\Repositories;

use App\Http\Modules\Bases\RepositoryBase;
use App\Http\Modules\Ecomapa\Models\FiguraEcomapa;

class FiguraEcomapaRepository extends RepositoryBase {

    public function __construct(FiguraEcomapa $model)
    {
        $this->model = $model;
    }

    public function obtenerTodas()
    {
        return FiguraEcomapa::with(['relacionesOrigen.figuraDestino', 'relacionesDestino.figuraOrigen'])->get();
    }

    public function crear($data)
    {
        return FiguraEcomapa::create($data);
    }

    public function obtenerPorId($id)
    {
        return FiguraEcomapa::with(['relacionesOrigen.figuraDestino', 'relacionesDestino.figuraOrigen'])->findOrFail($id);
    }

    public function actualizar($id, $data)
    {
        $figura = FiguraEcomapa::findOrFail($id);
        $figura->update($data);
        return $figura;
    }

    public function eliminar($id)
    {
        $figura = FiguraEcomapa::findOrFail($id);
        $figura->delete();
        return true;
    }
}
