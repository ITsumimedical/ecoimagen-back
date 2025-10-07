<?php

use App\Http\Modules\TipoActuaciones\Controllers\TipoActuacionController;
use Illuminate\Support\Facades\Route;

Route::prefix('tipo-actuacion', 'throttle:60,1')->group(function () {
    Route::controller(TipoActuacionController::class)->group(function() {
        Route::get('', 'listar')            ;//->middleware(['permission:tipoActuacionTutelas.listar']);
        Route::post('crear', 'crear')            ;//->middleware(['permission:tipoActuacionTutelas.crear']);
        Route::put('/{id}', 'actualizar')   ;//->middleware(['permission:tipoActuacionTutelas.actualizar']);
    });
});
