<?php

namespace App\Http\Modules\Notificacion\Repositories;

use App\Http\Modules\Bases\RepositoryBase;
use App\Http\Modules\Notificacion\Models\Notificacion;

class NotificacionRepository extends RepositoryBase
{
    protected $notificacionModel;

    public function __construct()
    {
        $this->notificacionModel = new Notificacion();
        parent::__construct($this->notificacionModel);
    }

    public function buscarNotificacionPorRedis(string $redisId)
    {
        return $this->notificacionModel->where('redis_id', $redisId)->first();
    }

    public function listarNotificacionesUsuario(int $userId)
    {
        return $this->notificacionModel->where('user_id', $userId)->get();
    }

}