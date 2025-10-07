<?php

namespace App\Http\Modules\Pqrsf\AsignadosPqrsf\Repositories;

use App\Http\Modules\Bases\RepositoryBase;
use App\Http\Modules\Pqrsf\AsignadosPqrsf\Model\Asignado;

class AsignadoPqrsfRepository extends RepositoryBase
{



  public function __construct(protected Asignado $asignadofModel) {}

  public function crearAsignado($area, $pqr)
  {
    $this->asignadofModel::create(['area_responsable_id' => $area, 'formulario_pqrsf_id' => $pqr, 'estado_id' => 1]);
  }

  public function estado($data)
  {
    return $this->asignadofModel::where('formulario_pqrsf_id', $data['pqrsf_id'])->where('area_responsable_id', $data['area'])->update(['estado_id' => 2]);
  }

  public function contadorEstado2($data)
  {
    return $this->asignadofModel::where('formulario_pqrsf_id', $data['pqrsf_id'])->where('estado_id', 2)->count();
  }

  public function contador($data)
  {
    return $this->asignadofModel::where('formulario_pqrsf_id', $data['pqrsf_id'])->where('estado_id', '!=', 5)->count();
  }

  public function obternerEstadoAnulado($data)
  {
    return $this->asignadofModel::where('formulario_pqrsf_id', $data['pqrsf_id'])->where('estado_id', '!=', 5)->get();
  }

  public function actualizarEstadoAnualdo($data)
  {
    return $this->asignadofModel::where('formulario_pqrsf_id', $data['pqrsf_id'])->where('estado_id', 1)->update(['estado_id' => 5]);
  }
}
