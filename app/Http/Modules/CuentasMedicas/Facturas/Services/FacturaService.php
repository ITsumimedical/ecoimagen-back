<?php

namespace App\Http\Modules\CuentasMedicas\Facturas\Services;

use Illuminate\Support\Carbon;
use App\Http\Modules\CuentasMedicas\AsignadoCuentasMedicas\Models\AsignadoCuentasMedica;
use App\Http\Modules\CuentasMedicas\AsignadoCuentasMedicas\Repositories\AsignadoCuentasMedicasRepository;

class FacturaService{

    public function __construct(private AsignadoCuentasMedicasRepository $asignadoCuentasMedicasRepository) {
    }

  public function facturasAsignadas($data){
    foreach ($data['af_id'] as $af_id) {
        $af[] = $af_id;
    }
    foreach ($data['permission_id'] as $permiso_id) {
        $permiso[] = $permiso_id;
    }

    for ($a = 0; $a < count($af); $a++) {
        for ($p = 0; $p < count($permiso); $p++) {
            $this->asignadoCuentasMedicasRepository->crearAsignado($af[$a],$permiso[$p]);
        }
    }

    return 'Factura asignada con exito!';
  }


  public function calcularDiasHabiles($afs){

    foreach ($afs as $af) {
        $fecha1 = Carbon::now()->format('Y-m-d');
        $fecha2 = Carbon::parse($af->created_at->format('Y-m-d'));
        $diasDiferencia = $fecha2->diffInDays($fecha1);
        if ($diasDiferencia < 0){
            $diasDiferencia = 0;
        }
        $af['diasHabiles'] = $diasDiferencia;
    }
    return $afs;
}


}
