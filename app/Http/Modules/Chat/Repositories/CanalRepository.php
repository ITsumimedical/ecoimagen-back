<?php

namespace App\Http\Modules\Chat\Repositories;

use Illuminate\Support\Facades\Auth;
use App\Http\Modules\Chat\Models\canal;
use App\Http\Modules\Bases\RepositoryBase;

class CanalRepository extends RepositoryBase {

    protected $Model;

    public function __construct(){
        $this->Model = new canal();
        parent::__construct($this->Model);
    }

    public function guardarCanal($data) {
        $data['user_crea_id'] = Auth::id();
        return $data;
    }
    

    public function listarCanalesEmpleados($users_id) {
        $canal = $this->model::select(
            'canals.id',
            'canals.user_crea_id',
            'E2.email_corporativo as email_user_recibe',
            'E2.primer_apellido as pa_user_recibe',
            'E2.primer_nombre as pn_user_recibe',
            'A2.nombre as area_user_recibe',
            'S2.nombre as sede_user_recibe',
            'E2.segundo_apellido as sa_user_recibe',
            'E2.segundo_nombre as sn_user_recibe',
            'CA2.nombre as cargo_user_recibe',
            'E1.email_corporativo as email_user_envia',
            'E1.primer_apellido as pa_user_envia',
            'E1.primer_nombre as pn_user_envia',
            'A1.nombre as area_user_envia',
            'S1.nombre as sede_user_envia',
            'E1.segundo_apellido as sa_user_envia',
            'E1.segundo_nombre as sn_user_envia',
            'CA1.nombre as cargo_user_envia')
        ->join('users as U1','canals.user_crea_id','U1.id')
        ->join('users as U2','canals.user_recibe_id','U2.id')
        ->join('empleados as E1','U1.id','E1.user_id')
        ->join('empleados as E2','U2.id','E2.user_id')
        ->leftjoin('area_ths as A2','A2.id','E2.areath_id')
            ->leftjoin('area_ths as A1','A1.id','E1.areath_id')
            ->leftjoin('sedes as S2','S2.id','E2.sede_id')
            ->leftjoin('sedes as S1','S1.id','E1.sede_id')
        ->leftjoin('contrato_empleados as C2','E2.id','C2.empleado_id')
            ->leftjoin('contrato_empleados as C1','E1.id','C1.empleado_id')
        ->leftjoin('cargos as CA2','C2.cargo_id','CA2.id')
            ->leftjoin('cargos as CA1','C1.cargo_id','CA1.id')
        ->where('user_crea_id',$users_id)
        ->orWhere('user_recibe_id',$users_id)
        ->orderBy('canals.id','desc')
        ->get();

        return $canal;
    }

}
