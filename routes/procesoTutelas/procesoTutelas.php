<?php

use App\Http\Modules\ProcesoTutela\Controllers\ProcesoTutelaController;
use Illuminate\Support\Facades\Route;

Route::prefix('proceso-tutela', 'throttle:60,1')->group(function () {
    Route::controller(ProcesoTutelaController::class)->group(function () {
        Route::get('listar', 'listar');
        Route::post('', 'crear');
        Route::post('buscar', 'buscar');
        Route::put('/{id}', 'actualizar');
        Route::put('estado/{id}', 'actualizarEstado');
    });
});
