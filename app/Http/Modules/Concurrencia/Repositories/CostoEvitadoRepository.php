<?php

namespace App\Http\Modules\Concurrencia\Repositories;

use App\Http\Modules\Bases\RepositoryBase;
use App\Http\Modules\Concurrencia\Models\CostoEvitado;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;

class CostoEvitadoRepository extends RepositoryBase {

    public function __construct(protected CostoEvitado $costoModel) {
        parent::__construct($this->costoModel);
    }

    public function guardarCosto($request)
    {
       $costo = CostoEvitado::create([
          'costo' => $request['costo'],
          'descripcion' => $request['descripcion'],
          'valor' => $request['valor'],
          'tipo_alta' => $request['tipo_alta'],
          'ingreso_concurrencia_id' => $request['ingreso_concurrencia_id'],
          'user_id' => Auth::id(),
       ]);
       return $costo;
    }

    public function listarCosto($request)
    {
        $consulta = $this->costoModel->select('costo_evitados.*')
            ->where('ingreso_concurrencia_id', $request->id)
            ->with(['user.operador', 'userElimina.operador'])
            ->get();
        return $consulta;
    }

    public function eliminarCosto($request){
        return $this->costoModel->where('id',$request->id)->update([
            'deleted_at' => Carbon::now(),
            'user_elimina_id' => Auth::id(),
            'motivo_eliminacion' => $request['motivo_eliminacion']
        ]);
    }
}
