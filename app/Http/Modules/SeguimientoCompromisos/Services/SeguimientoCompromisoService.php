<?php

namespace App\Http\Modules\SeguimientoCompromisos\Services;

use Illuminate\Support\Facades\Auth;
use App\Http\Modules\SeguimientoCompromisos\Repositories\SeguimientoCompromisoRepository;

class SeguimientoCompromisoService
{
    protected $repository;

    public function __construct(){
        $this->respository = new SeguimientoCompromisoRepository();
    }

    public function prepararData($data,$id){
        $data['calificacion_competencia_id'] = $id;
        $data['user_id'] = Auth::id();
        return $data;
    }

    public function cambiarEstado($id)
    {
        $seguimiento= SeguimientoCompromiso::find('id',$id);
        $seguimiento['aprobado'] = true;
        return $seguimiento;
    }

}
