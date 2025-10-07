<?php

namespace App\Http\Modules\Colegios\Repositories;

use App\Http\Modules\Bases\RepositoryBase;
use App\Http\Modules\Colegios\Models\Colegio;

class ColegioRepository extends RepositoryBase
{

    public function __construct(protected Colegio $colegioModel)
    {
        parent::__construct($colegioModel);
    }

    public function listarColegios()
    {
        return $this->colegioModel::select('colegios.id', 'colegios.nombre', 'colegios.codigo_dane_colegio', 'colegios.estado', 'municipios.nombre as municipio', 'municipios.id as municipio_id',)
            ->join('municipios', 'colegios.municipio_id', 'municipios.id')
            ->where('colegios.estado', true)
            ->get();
    }

    public function listarTodos()
    {
        $cantidad = request()->get('cantidad' );

        $colegios = $this->colegioModel::select(
            'colegios.id',
            'colegios.nombre',
            'colegios.codigo_dane_colegio',
            'colegios.estado',
            'municipios.nombre as municipio',
            'municipios.id as municipio_id'
        )
            ->join('municipios', 'colegios.municipio_id', 'municipios.id')
            ->when(request()->filled('nombre'), function ($query) {
                $query->where('colegios.nombre', 'LIKE', '%' . request('nombre') . '%');
            })
            ->when(request()->filled('codigo'), function ($query) {
                $query->where('colegios.codigo_dane_colegio', 'LIKE', '%' . request('codigo') . '%');
            });

        return $colegios->paginate($cantidad);
    }



    public function buscarColegioPorNombre($nombre)
    {
        return Colegio::where('nombre', 'ILIKE', "%{$nombre}%")
            ->get();
    }
}
