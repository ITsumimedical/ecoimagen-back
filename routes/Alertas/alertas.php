<?php

use App\Http\Modules\Alertas\Controllers\AlertasController;
use Illuminate\Support\Facades\Route;

Route::prefix('alertas')->group(function () {
    Route::controller(AlertasController::class)->group(function () {
        Route::post('crearAlertaMedicamento','crearAlertaMedicamento');
        Route::post('crearAlertaPrincipal','crearAlertaPrincipal');
        Route::get('listarAlertasPrincipales','listarAlertasPrincipales');
        Route::get('listarCodesumis','listarCodesumis');
        Route::put('actualizar/{id}', 'actualizar');
        Route::put('cambiarEstado/{id}', 'cambiarEstado');
        Route::post('buscarAlergico', 'buscarAlergico');
        Route::post('buscarDesabastecimiento', 'buscarDesabastecimiento');
        Route::post('buscarAlertas', 'buscarAlertas');
        Route::post('auditorias', 'listarAuditoria');
        Route::post('verificarInteraccion', 'verificarInteraccion');
        Route::post('crearAuditoria', 'crearAuditoria');
    });
});
