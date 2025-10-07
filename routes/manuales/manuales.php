<?php

use App\Http\Modules\Inicio\Controllers\ManualesController;
use Illuminate\Support\Facades\Route;

Route::prefix('manuales', 'throttle:60,1')->group(function () {
    Route::controller(ManualesController::class)->group(function () {
        Route::get('/listarTodos', 'listarTodos');
        Route::post('/crearManual', 'crearManual');
        Route::post('/cambiarEstadoManual', 'cambiarEstadoManual');
        Route::post('/actualizarManual/{id}', 'actualizarManual');
        Route::get('/listarActivos', 'listarActivos');
    });
});