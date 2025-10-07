<?php

namespace App\Http\Modules\CuentasMedicas\AsignadoCuentasMedicas\Repositories;

use App\Http\Modules\Bases\RepositoryBase;
use App\Http\Modules\CuentasMedicas\AsignadoCuentasMedicas\Models\AsignadoCuentasMedica;
use App\Http\Modules\CuentasMedicas\CodigoGlosas\Models\CodigoGlosa;


class AsignadoCuentasMedicasRepository extends RepositoryBase {



    public function __construct(protected AsignadoCuentasMedica $asignadoCuentasMedicaModel) {
    }

    public function crearAsignado($af_if,$permiso_id){
        $this->asignadoCuentasMedicaModel->updateOrCreate([
            
            'af_id' => $af_if
        ],[
            'permission_id' => $permiso_id,
        ]
    
    );
    }



}
