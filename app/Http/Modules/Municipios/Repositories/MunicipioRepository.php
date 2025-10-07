<?php

namespace App\Http\Modules\Municipios\Repositories;

use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Redis;
use App\Http\Modules\Bases\RepositoryBase;
use App\Http\Modules\Municipios\Models\Municipio;

class MunicipioRepository extends RepositoryBase
{

    protected $municipioModel;

    public function __construct()
    {
        $this->municipioModel = new Municipio();
        parent::__construct($this->municipioModel);
    }


    /**
     * Listar Municipios y cacharlos con REDIS
     *
     * @author Calvarez
     */
    public function listarMunicipios()
    {
        return Cache::rememberForever('municipios', function () {
            return $this->municipioModel::select('id', 'nombre', 'codigo_dane', 'departamento_id')
                ->get()
                ->toArray();
        });
    }

    /**
     * Listar Municipios por departamentos
     *
     * @author Calvarez
     */
    public function listarMunicipiosPorDepartamento(int $departamentoId)
    {
        $municipios = $this->listarMunicipios();

        return collect($municipios)->filter(function ($municipio) use ($departamentoId) {
            return $municipio['departamento_id'] == $departamentoId;
        })->values()->toArray();
    }

    public function listarPorDepartamento(int $departamentoId): Collection
    {
        return $this->municipioModel->whereDepartamento($departamentoId)->get();
    }
}
