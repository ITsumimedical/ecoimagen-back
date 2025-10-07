<?php

namespace App\Http\Modules\Eventos\GestionEventos\Repositories;

use App\Http\Modules\Bases\RepositoryBase;
use App\Http\Modules\Eventos\GestionEventos\Models\GestionEvento;

class GestionEventoRepository extends RepositoryBase
{

    protected $gestionEventoRepository;

    public function __construct()
    {
        $this->gestionEventoRepository = new GestionEvento();
        parent::__construct($this->gestionEventoRepository);
    }

    public function historicoGestionEvento($evento_adverso_id)
    {
        return $this->gestionEventoRepository->with(
            'usuario:id',
            'usuario.operador:user_id,nombre,apellido',
            'evento:id,motivo_anulacion_id,clasificacion_anulacion,otros_motivo_anulacion',
            'evento.motivoAnulacion:id,nombre'
        )->where('evento_adverso_id', $evento_adverso_id)->get();
    }
}
