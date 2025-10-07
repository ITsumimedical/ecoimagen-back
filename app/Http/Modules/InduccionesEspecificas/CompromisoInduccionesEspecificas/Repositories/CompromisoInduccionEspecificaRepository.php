<?php

namespace App\Http\Modules\InduccionesEspecificas\CompromisoInduccionesEspecificas\Repositories;

use App\Http\Modules\Bases\RepositoryBase;
use App\Http\Modules\InduccionesEspecificas\CompromisoInduccionesEspecificas\Models\CompromisoInduccionEspecifica;

class CompromisoInduccionEspecificaRepository extends RepositoryBase {

    protected $compromiso;

    public function __construct() {
        $this->compromiso = new CompromisoInduccionEspecifica();
        parent::__construct($this->compromiso);
    }

    public function listarCompromiso($id){
        $compromisos = CompromisoInduccionEspecifica::select(
            'compromiso_induccion_especificas.id', 'compromiso_induccion_especificas.induccion_especifica_id', 'compromiso_induccion_especificas.usuario_registra_id',
            'compromiso_induccion_especificas.created_at', 'compromiso_induccion_especificas.compromiso', 'compromiso_induccion_especificas.tiempo_seguimiento',
            'empleados.nombre_completo as nombreRegistra')
        ->join('users', 'users.id', 'usuario_registra_id')
        ->join('empleados', 'empleados.id', 'usuario_registra_id')
        ->where('compromiso_induccion_especificas.induccion_especifica_id',$id)
        ->get();
        return $compromisos;
    }
}
