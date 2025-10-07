<?php
namespace App\Http\Modules\Clientes\Repositories;

use App\Http\Modules\Bases\RepositoryBase;
use App\Http\Modules\ClienteMesaAyuda\Models\Clientemesaayuda;
use App\Http\Modules\Clientes\Models\Cliente;

class ClienteRepository extends RepositoryBase
{
    public function __construct(protected Clientemesaayuda $clienteModel)
    {
    }

    public function listarClientes(){
        return $this->clienteModel::orderBy('id','desc')->get();
    }

    /**
     * Cambia el estado de un cliente
     * @param int $clienteId
     * @return bool
     * @author Daniel
     */


    public function cambiarEstado(int $clienteId){
        $cliente=$this->clienteModel->findOrFail($clienteId);
        return $cliente->update([
            "revoked"=>!$cliente->revoked
        ]);
    }

    public function encontrarId($id)
    {
        return $this->clienteModel->findOrFail($id);
    }

}
