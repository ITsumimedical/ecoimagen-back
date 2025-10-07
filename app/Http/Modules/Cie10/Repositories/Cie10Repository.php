<?php

namespace App\Http\Modules\Cie10\Repositories;

use App\Http\Modules\Bases\RepositoryBase;
use App\Http\Modules\Cie10\Models\Cie10;
use FontLib\TrueType\Collection;
use Illuminate\Support\Facades\DB;

class Cie10Repository extends RepositoryBase
{

    protected $cie10Model;

    public function __construct()
    {
        $cie10Model = new Cie10();
        parent::__construct($cie10Model);
        $this->cie10Model = $cie10Model;
    }

    public function listarFiltro($request)
    {
        return $this->cie10Model::with(['eventoSivigila'])->buscarCie10($request->valor)
            ->where('estado', true)
            ->get();
    }


    public function listarAntecedentesPersonales()
    {
        return $this->cie10Model->where('codigo_cie10', 'LIKE', 'Z%')->get(['id', 'codigo_cie10', 'nombre']);
    }

    public function listarC10()
    {
        return $this->cie10Model::get();
    }
}
