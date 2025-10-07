<?php

namespace App\Http\Modules\testMchat\Repositories;

use App\Http\Modules\Bases\RepositoryBase;
use App\Http\Modules\testMchat\Model\mChat;

class mChatRepository extends RepositoryBase
{


    public function __construct(protected mChat $mchat)
    {
        parent::__construct($this->mchat);
    }

    public function obtenerDatosporAfiliado($afiliadoId)
    {
        return $this->mchat
            ->whereHas('consulta', function ($query) use ($afiliadoId) {
                $query->where('afiliado_id', $afiliadoId);
            })
            ->latest('id')
            ->first();
    }
    public function crearMchat(array $data)
    {
        return $this->mchat->updateOrCreate(
            ['consulta_id' => $data['consulta_id']],
            $data
        );
    }
}
