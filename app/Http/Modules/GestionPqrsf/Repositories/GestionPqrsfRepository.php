<?php

namespace App\Http\Modules\GestionPqrsf\Repositories;

use Illuminate\Support\Facades\Auth;
use Illuminate\Database\Eloquent\Model;
use App\Http\Modules\Bases\RepositoryBase;
use App\Http\Modules\GestionPqrsf\Models\GestionPqrsf;
use Carbon\Carbon;

class GestionPqrsfRepository extends RepositoryBase {

    protected $GestionPqrsfModel;

    public function __construct() {
        $this->GestionPqrsfModel = new GestionPqrsf();
        parent::__construct($this->GestionPqrsfModel);
    }

    public function guardarGestion($pqr_id,$afiliado_id,$tipo,$motivo,$user_id)
    {
       return $this->GestionPqrsfModel->create([
            'formulario_pqrsf_id' => $pqr_id,
            'user_id' => $user_id,
            'afiliado_id' => $afiliado_id,
            'tipo_id' => $tipo,
            'motivo' => $motivo,
            'fecha' => Carbon::now()
        ]);
    }

    public function guardarGestionRespuesta($pqr_id,$afiliado_id,$tipo,$motivo,$responsable)
    {
       return $this->GestionPqrsfModel->create([
            'formulario_pqrsf_id' => $pqr_id,
            'user_id' => Auth::user()->id,
            'afiliado_id' => $afiliado_id,
            'tipo_id' => $tipo,
            'motivo' => $motivo,
            'responsable' => $responsable,
            'fecha' => Carbon::now()
        ]);
    }

    public function guardarGestionCargue($pqr_id,$afiliado_id,$tipo,$motivo,$user_id)
    {
       return $this->GestionPqrsfModel->create([
            'formulario_pqrsf_id' => $pqr_id,
            'user_id' => $user_id,
            'afiliado_id' => $afiliado_id,
            'tipo_id' => $tipo,
            'motivo' => $motivo,
            'fecha' => Carbon::now()
        ]);
    }

    public function guardarGestionResponsable($pqr_id,$afiliado_id,$tipo,$motivo,$user_id,$area_responsable_id)
    {
       return $this->GestionPqrsfModel->create([
            'formulario_pqrsf_id' => $pqr_id,
            'user_id' => $user_id,
            'afiliado_id' => $afiliado_id,
            'tipo_id' => $tipo,
            'motivo' => $motivo,
            'fecha' => Carbon::now(),
            'area_responsable_id'=> $area_responsable_id
        ]);
    }




}
