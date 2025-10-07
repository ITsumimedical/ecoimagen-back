<?php

use App\Http\Modules\Inicio\Controllers\VideosController;
use Illuminate\Support\Facades\Route;

Route::prefix('videos', 'throttle:60,1')->group(function () {
    Route::controller(VideosController::class)->group(function () {
        Route::get('/listarTodos', 'listarTodos');
        Route::post('/crearVideo', 'crearVideo');
        Route::post('/cambiarEstadoVideo', 'cambiarEstadoVideo');
        Route::post('/actualizarVideo/{id}', 'actualizarVideo');
        Route::get('/listarActivos', 'listarActivos');
    });
});