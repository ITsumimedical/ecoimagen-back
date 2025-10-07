<?php

namespace App\Http\Modules\TipoUsuarios\Repositories;

use App\Http\Modules\Bases\RepositoryBase;
use App\Http\Modules\TipoUsuarios\Models\TipoUsuario;

class TipoUsuarioRepository extends RepositoryBase
{
    protected $tipoUsuarioModel;

    public function __construct() {
        $this->tipoUsuarioModel = new TipoUsuario();
        parent::__construct($this->tipoUsuarioModel);
    }

    public function listarTipoUsuario($data)
    {
        $consulta = $this->tipoUsuarioModel->where('id','<>', 2)->where('id','<>', 1)->where('id','<>', 4)->get();

        return $consulta;
    }

}
