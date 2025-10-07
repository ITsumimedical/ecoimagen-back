<?php

namespace App\Http\Modules\Concurrencia\Repositories;

use App\Http\Modules\Bases\RepositoryBase;
use App\Http\Modules\Concurrencia\Models\EventosSeguridad;
use Carbon\Carbon;

class EventoSeguridadRepository extends RepositoryBase {

    public function __construct(protected EventosSeguridad $eventoSeguridadModel) {
        parent::__construct($this->eventoSeguridadModel);
    }

    public function guardarEvento($request)
    {
       $evento = EventosSeguridad::create([
          'evento' => $request['evento'],
          'observaciones' => $request['observaciones'],
          'ingreso_concurrencia_id' => $request['ingreso_concurrencia_id'],
       ]);
       return $evento;
    }

    public function listarEvento($request)
    {
        $consulta = $this->eventoSeguridadModel->select('eventos_seguridads.*')
            ->where('ingreso_concurrencia_id', $request->id)
            ->get();
        return $consulta;
    }

    public function eliminarEvento($request){
        return $this->eventoSeguridadModel->where('id',$request->id)->update([
            'deleted_at' => Carbon::now()
        ]);
    }
}
