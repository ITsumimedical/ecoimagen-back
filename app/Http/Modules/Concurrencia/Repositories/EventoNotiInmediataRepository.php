<?php

namespace App\Http\Modules\Concurrencia\Repositories;

use App\Http\Modules\Bases\RepositoryBase;
use App\Http\Modules\Concurrencia\Models\EventoNotiInmediata;
use Carbon\Carbon;

class EventoNotiInmediataRepository extends RepositoryBase {

    public function __construct(protected EventoNotiInmediata $eventoNotiInmediataModel) {
        parent::__construct($this->eventoNotiInmediataModel);
    }

    public function guardarEvento($request)
    {
       $evento = EventoNotiInmediata::create([
          'evento' => $request['evento'],
          'descripciones' => $request['descripciones'],
          'ingreso_concurrencia_id' => $request['ingreso_concurrencia_id'],
       ]);
       return $evento;
    }

    public function listarEvento($request)
    {
        $consulta = $this->eventoNotiInmediataModel->select('evento_noti_inmediatas.*')
            ->where('ingreso_concurrencia_id', $request->id)
            ->get();
        return $consulta;
    }

    public function eliminarEvento($request){
        return $this->eventoNotiInmediataModel->where('id',$request->id)->update([
            'deleted_at' => Carbon::now()
        ]);
    }
}
