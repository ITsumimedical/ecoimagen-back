<?php

namespace App\Http\Modules\Eventos\AccionesInseguras\Repositories;

use App\Http\Modules\Bases\RepositoryBase;
use App\Http\Modules\Eventos\AccionesInseguras\Models\AccionesInsegura;

class AccionInseguraRepository extends RepositoryBase
{

    protected $accionInseguraModel;

    public function __construct()
    {
        $this->accionInseguraModel = new AccionesInsegura();
        parent::__construct($this->accionInseguraModel);
    }

    public function listarAccionInsegura($data, $id)
    {
        /** Definimos el orden*/
        $orden = isset($data->orden) ? $data->orden : 'desc';
        if ($data->page) {
            $filas = $data->filas ? $data->filas : 10;
            return $this->model
                ->orderBy('created_at', $orden)
                ->paginate($filas)
                ->whereNull('deleted_at')
                ->where('analisis_evento_id', $id);
        } else {
            return $this->model
                ->orderBy('created_at', $orden)
                ->whereNull('deleted_at')
                ->where('analisis_evento_id', $id)
                ->get();
        }
    }

    public function actualizarDeletedAt($accionInseguraEvento)
    {
        try {
            $accionInseguraEvento->deleted_at = now();

            $accionInseguraEvento->update();

            return $accionInseguraEvento;
        } catch (\Throwable $th) {
            throw new \Exception("Error al eliminar el registro: " . $th->getMessage());
        }
    }
}
