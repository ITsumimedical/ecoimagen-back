<?php

use App\Http\Modules\BarreraAccesos\Controllers\TipoBarreraAccesoController;
use Illuminate\Support\Facades\Route;

Route::prefix('tipo-barrera-acceso')->group( function () {
    Route::controller(TipoBarreraAccesoController::class)->group(function (){
        Route::get('listar-tipos-barrera_acceso-activos','listarTiposBarrerasAccesoActivos');
        Route::post('listar-tipos-barrera_acceso','listarTiposBarrerasAcceso');
        Route::post('crear-tipo_barrera_acceso', 'crearTiposBarrerasAcceso');
        Route::put('actualizar-tipo_barrera_acceso/{id}', 'actualizarTiposBarrerasAcceso');
        Route::put('cambiar_estado-tipo_barrera_acceso/{id}', 'cambiarEstadoTiposBarrerasAcceso');
    });
});
