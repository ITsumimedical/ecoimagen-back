<?php

namespace App\Http\Modules\InduccionesEspecificas\SeguimientoCompromisoInduccionesEspecificas\Repositories;

use App\Http\Modules\Bases\RepositoryBase;
use App\Http\Modules\InduccionesEspecificas\SeguimientoCompromisoInduccionesEspecificas\Models\SeguimientoCompromisoInduccionEspecifica;

class SeguimientoCompromisoInduccionEspecificaRepository extends RepositoryBase {

    protected $seguimientoModel;

    public function __construct() {
        $this->seguimientoModel = new SeguimientoCompromisoInduccionEspecifica();
        parent::__construct($this->seguimientoModel);
    }

    public function listarSeguimiento($id){
        $seguimientos = SeguimientoCompromisoInduccionEspecifica::select(
            'seguimiento_compromiso_induccion_especificas.id', 'seguimiento_compromiso_induccion_especificas.estado_id',
            'seguimiento_compromiso_induccion_especificas.nota_adicional', 'seguimiento_compromiso_induccion_especificas.created_at',
            'seguimiento_compromiso_induccion_especificas.compromiso_induccion_especifica_id', 'estados.nombre as nombreEstado',
            'compromiso_induccion_especificas.id as compromiso_id', 'compromiso_induccion_especificas.compromiso', 'compromiso_induccion_especificas.tiempo_seguimiento',
            'compromiso_induccion_especificas.usuario_registra_id', 'compromiso_induccion_especificas.induccion_especifica_id', 'empleados.nombre_completo as nombreRegistra'
        )
        ->join('estados', 'seguimiento_compromiso_induccion_especificas.estado_id', 'estados.id')
        ->join('compromiso_induccion_especificas', 'seguimiento_compromiso_induccion_especificas.id', 'seguimiento_compromiso_induccion_especificas.compromiso_induccion_especifica_id')
        ->join('users', 'users.id', 'usuario_registra_id')
        ->join('empleados', 'empleados.id', 'usuario_registra_id')
        ->where('seguimiento_compromiso_induccion_especificas.id', $id)
        ->get();

        return $seguimientos;
    }

    public function crearSeguimiento($id){
       return $this->seguimientoModel::create(['compromiso_induccion_especifica_id' => $id, 'estado_id' => 10]);
    }
}
