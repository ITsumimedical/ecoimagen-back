<?php

namespace App\Http\Modules\Concurrencia\Repositories;

use App\Http\Modules\Bases\RepositoryBase;
use App\Http\Modules\Concurrencia\Models\EventoCentinela;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;

class EventoCentinelaRepository extends RepositoryBase {

    public function __construct(protected EventoCentinela $eventoCentinelaModel) {
        parent::__construct($this->eventoCentinelaModel);
    }

    public function guardarEvento($request)
    {
       $evento = EventoCentinela::create([
          'evento' => $request['evento'],
          'observaciones' => $request['observaciones'],
          'ingreso_concurrencia_id' => $request['ingreso_concurrencia_id'],
       ]);
       return $evento;
    }

    public function listarEvento($request)
    {
        $consulta = $this->eventoCentinelaModel->select('evento_centinelas.*')
            ->where('ingreso_concurrencia_id', $request->id)
            ->get();
        return $consulta;
    }

    public function eliminarEvento($request){
        return $this->eventoCentinelaModel->where('id',$request->id)->update([
            'deleted_at' => Carbon::now()
        ]);
    }
}
