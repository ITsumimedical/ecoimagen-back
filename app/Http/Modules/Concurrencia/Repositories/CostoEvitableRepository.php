<?php

namespace App\Http\Modules\Concurrencia\Repositories;

use App\Http\Modules\Bases\RepositoryBase;
use App\Http\Modules\Concurrencia\Models\CostoEvitable;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;

class CostoEvitableRepository extends RepositoryBase {

    public function __construct(protected CostoEvitable $costoEvitableModel) {
        parent::__construct($this->costoEvitableModel);
    }

    public function guardarCosto($request)
    {
       $evento = CostoEvitable::create([
          'costo' => $request['costo'],
          'objecion' => $request['objecion'],
          'descripcion' => $request['descripcion'],
          'valor' => $request['valor'],
          'ingreso_concurrencia_id' => $request['ingreso_concurrencia_id'],
          'user_id' => Auth::id(),
       ]);
       return $evento;
    }

    public function listarCosto($request)
    {
        $consulta = $this->costoEvitableModel->select('costo_evitables.*')
            ->where('ingreso_concurrencia_id', $request->id)
            ->with(['user.operador', 'userElimina.operador'])
            ->get();
        return $consulta;
    }

    public function eliminarCosto($request){
        return $this->costoEvitableModel->where('id',$request->id)->update([
            'deleted_at' => Carbon::now(),
            'user_elimina_id' => Auth::id(),
            'motivo_eliminacion' => $request['motivo_eliminacion']
        ]);
    }
}
