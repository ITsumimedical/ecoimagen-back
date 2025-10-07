<?php

use App\Http\Modules\Inicio\Controllers\BoletinesController;
use Illuminate\Support\Facades\Route;

Route::prefix('boletines', 'throttle:60,1')->group(function () {
    Route::controller(BoletinesController::class)->group(function () {
        Route::get('/listarTodos', 'listarTodos');
        Route::post('/crearBoletin', 'crearBoletin');
        Route::post('/cambiarEstadoBoletin', 'cambiarEstadoBoletin');
        Route::post('/actualizarBoletin/{id}', 'actualizarBoletin');
        Route::get('/listarActivos', 'listarActivos');
    });
});
