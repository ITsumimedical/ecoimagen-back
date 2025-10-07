<?php

use Illuminate\Support\Facades\Route;
use App\Http\Modules\ImagenesInicio\Controllers\ImagenesInicioController;

Route::prefix('imagenes-inicio', 'throttle:60,1')->group(function () {
    Route::controller(ImagenesInicioController::class)->group(function () {
        Route::get('listarTodos', 'listarTodos');
        Route::get('listarActivos', 'listarActivos');
        Route::post('/crearImagen', 'crearImagen');
        Route::post('/cambiarEstadoImagen', 'cambiarEstadoImagen');
        Route::delete('/eliminarImagen/{id}', 'eliminarImagen');
    });
});
