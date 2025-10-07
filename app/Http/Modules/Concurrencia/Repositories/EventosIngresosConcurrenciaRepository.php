<?php

namespace App\Http\Modules\Concurrencia\Repositories;

use Carbon\Carbon;
use App\Http\Modules\Bases\RepositoryBase;
use App\Http\Modules\Concurrencia\Models\EventosIngresosConcurrencia;
use Illuminate\Support\Facades\Auth;

class EventosIngresosConcurrenciaRepository extends RepositoryBase {

    public function __construct(protected EventosIngresosConcurrencia $eventoModel) {
        parent::__construct($this->eventoModel);
    }

    public function guardarEvento($request)
    {
       $evento = EventosIngresosConcurrencia::create([
          'evento' => $request['evento'],
          'observaciones' => $request['observaciones'],
          'tipo_evento' => $request['tipo_evento'],
          'user_id' => Auth::id(),
          'ingreso_concurrencia_id' => $request['ingreso_concurrencia_id'],
       ]);
       return $evento;
    }

    public function listarEvento($request)
    {
        $consulta = $this->eventoModel->select('eventos_ingresos_concurrencias.*')
            ->where('ingreso_concurrencia_id', $request->id)
            ->with(['user.operador', 'userElimina.operador'])
            ->get();
        return $consulta;
    }

    public function eliminarEvento($request){
        return $this->eventoModel->where('id',$request->id)->update([
            'deleted_at' => Carbon::now(),
            'user_elimina_id' => Auth::id(),
            'motivo_eliminacion' => $request['motivo_eliminacion']
        ]);
    }
}
