<?php

use App\Http\Modules\AdmisionesUrgencias\Controllers\AdmisionesUrgenciaController;
use Illuminate\Support\Facades\Route;

Route::prefix('admisiones')->group(function () {
    Route::controller(AdmisionesUrgenciaController::class)->group(function () {
        Route::post('listarAdmisionesUrgencias', 'index');
        Route::post('guardarAdmisionesUrgencias', 'store');
        Route::get('listarContratos', 'listarTodosContratos');
        Route::post('firmaAfiliado','firmaAfiliado');
        Route::post('firmaAcompañante','firmaAcompañante');
        Route::post('inasistir','inasistir');
        Route::post('actualizarEstadoAdmision','actualizarEstadoAdmision');
        Route::post('listarAdmisionesUrgenciasEvolucion','listarAdmisionesUrgenciasEvolucion');
        Route::post('listarAsignacionCama','listarAsignacionCama');
    });
});


