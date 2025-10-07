<?php

use Illuminate\Support\Facades\Route;
use App\Http\Modules\ImagenesSoporte\Controllers\ImagenesSoporteController;

Route::prefix('imagenes-soporte', 'throttle:60,1')->group(function () {
    Route::controller(ImagenesSoporteController::class)->group(function () {
        Route::get('listarTodos', 'listarTodos');
        Route::get('listarActivos', 'listarActivos');
        Route::post('crearImagen', 'crearImagen');
        Route::post('cambiarEstadoImagen', 'cambiarEstadoImagen');
        Route::delete('/eliminarImagen/{id}', 'eliminarImagen');
    });
});
