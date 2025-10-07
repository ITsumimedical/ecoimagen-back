<?php

use App\Http\Modules\SeguimientoCompromisos\Controllers\SeguimientoCompromisoController;
use Illuminate\Support\Facades\Route;

Route::prefix('seguimiento-compromiso', 'throttle:60,1')->group(function () {
    Route::controller(SeguimientoCompromisoController::class)->group(function () {
        Route::get('listar/{id}', 'listar');
        Route::post('crear/{id}', 'crear')                                ;//->middleware('permission:seguimiento-compromiso.crear');
        Route::put('/{id}', 'actualizar')                                 ;//->middleware('permission:seguimiento-compromiso.actualizar');
        Route::post('finalizar-Seguimiento/{id}', 'finalizarSeguimiento') ;//->middleware('permission:seguimiento-compromiso.actualizar');
    });
});
