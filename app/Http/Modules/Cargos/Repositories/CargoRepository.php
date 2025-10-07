<?php

namespace App\Http\Modules\Cargos\Repositories;

use App\Http\Modules\Bases\RepositoryBase;
use App\Http\Modules\Cargos\Models\Cargo;

class CargoRepository extends RepositoryBase
{
    private $cargoModel;

    public function __construct()
    {
        $this->cargoModel = new Cargo();
        parent::__construct($this->cargoModel);
    }

    public function listarCargos($request)
    {
        $pagina = $request->input('pagina', 1);
        $cantidad = $request->input('cantidad', 10);
        $campoBusqueda = $request->input('campoBusqueda', '');

        $query = Cargo::select('id', 'nombre', 'funciones');

        if ($campoBusqueda) {
            $query->where(function ($q) use ($campoBusqueda) {
                $q->where('nombre', 'ILIKE', "%{$campoBusqueda}%");
            });
        }

        return $query->paginate($cantidad, ['*'], 'pagina', $pagina);
    }

    public function listarTodos() {
        return Cargo::select('id', 'nombre', 'funciones')->get();
    }
}
