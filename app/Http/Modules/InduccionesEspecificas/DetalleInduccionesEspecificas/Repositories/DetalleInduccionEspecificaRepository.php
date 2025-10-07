<?php

namespace App\Http\Modules\InduccionesEspecificas\DetalleInduccionesEspecificas\Repositories;

use App\Http\Modules\Bases\RepositoryBase;
use App\Http\Modules\InduccionesEspecificas\DetalleInduccionesEspecificas\Models\DetalleInduccionEspecifica;

class DetalleInduccionEspecificaRepository extends RepositoryBase {

    protected $DetalleInduccionModel;

    public function __construct() {
        $this->DetalleInduccionModel = new DetalleInduccionEspecifica();
        parent::__construct($this->DetalleInduccionModel);
    }

    public function listarConInduccion($id){
        $detalles = DetalleInduccionEspecifica::select(
            'detalle_induccion_especificas.id', 'detalle_induccion_especificas.tema_id', 'detalle_induccion_especificas.usuario_registra_id',
            'detalle_induccion_especificas.descripcion_actividad', 'detalle_induccion_especificas.usuario_ingreso_plataforma',
            'detalle_induccion_especificas.contrasena_ingreso_plataforma', 'detalle_induccion_especificas.fecha_realizacion', 'detalle_induccion_especificas.realizado',
            'detalle_induccion_especificas.created_at', 'tema_induccion_especificas.nombre as nombreTema', 'empleadoReporta.nombre_completo as empleadoReporta'
        )
        ->join('tema_induccion_especificas', 'tema_induccion_especificas.id', 'detalle_induccion_especificas.tema_id')
        ->join('users', 'users.id', 'usuario_registra_id')
        ->join('empleados as empleadoReporta', 'users.id', 'empleadoReporta.user_id')
        ->where('induccion_especifica_id', $id)
        ->get();

        return $detalles;

    }
}
