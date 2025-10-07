<?php

use App\Http\Modules\CodigoServicio\Controllers\CodigoServicioController;
use Illuminate\Support\Facades\Route;

Route::prefix('codigoServicio', 'throttle:60,1')->group(function () {
    Route::controller(CodigoServicioController::class)->group(function () {
        Route::post('crear', 'crear');
        Route::get('listar', 'listar');
        Route::put('actualizar/{id}', 'actualizar');
        Route::post('cambiarEstado/{id}', 'cambiarEstado');
    });
});
