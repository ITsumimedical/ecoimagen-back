<?php

namespace App\Http\Modules\ClienteMesaAyuda\Repositories;

use App\Http\Modules\Bases\RepositoryBase;
use App\Http\Modules\ClienteMesaAyuda\Models\Clientemesaayuda;

class ClienteMesaAyudaRepository extends RepositoryBase
{
    protected $modelCliente;

    public function __construct()
    {
         $this->modelCliente = new Clientemesaayuda();
    }

    public function listar($request)
    {
        return $this->modelCliente->get();

    }

    public function buscarPorNombre(string $nombre)
    {
        return $this->modelCliente->where('nombre', $nombre)->first();
    }

    public function listarClientes()
    {
        return $this->modelCliente->orderBY("id", "asc")->get();
    }

    public function listarAsigandas()
    {

    }


}
