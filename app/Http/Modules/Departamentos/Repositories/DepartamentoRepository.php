<?php

namespace App\Http\Modules\Departamentos\Repositories;

use Illuminate\Support\Facades\Cache;
use App\Http\Modules\Bases\RepositoryBase;
use App\Http\Modules\Departamentos\Models\Departamento;

class DepartamentoRepository extends RepositoryBase{
    protected $model;

    public function __construct(){
       $modelo = new Departamento();
       parent::__construct($modelo);
       $this->model = $modelo;
    }

    //Listar departamentos y cacharlos con REDIS
    /**
     * listarDepartamentos
     *
     * @author Calvarez
     */
    public function listarDepartamentos(){
        return Cache::rememberForever('departamentos', function () {
			return $this->model::select('id', 'nombre', 'codigo_dane', 'pais_id')
				->get();
		});
    }
}
