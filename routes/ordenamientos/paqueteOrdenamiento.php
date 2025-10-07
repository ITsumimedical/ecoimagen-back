<?php

use App\Http\Modules\Ordenamiento\Controllers\PaqueteOrdenamientoController;
use Illuminate\Support\Facades\Route;

Route::prefix('paquetes-ordenamientos')->group(function () {
    Route::controller(PaqueteOrdenamientoController::class)->group(function () {
        // actualizacion
        Route::post('listar-paquetes', 'listarPaquete');
        Route::post('crear', 'crear');
        Route::put('/{id}', 'actualizar');
        Route::put('cambiarEstado/{id}', 'cambiarEstado');
        Route::post('{id}/asignar-cups', 'asignarCups');
        Route::post('{id}/asignar-codesumis', 'asignarCodesumis');
        Route::get('{id}/cups', 'obtenerCups');
        Route::get('{id}/codesumis', 'obtenerCodesumis');
    });
});
