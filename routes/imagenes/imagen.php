<?php

use App\Http\Modules\Imagenes\Controllers\ImagenController;
use Illuminate\Support\Facades\Route;

Route::prefix('imagenes', 'throttle:60,1')->group(function () {
    Route::controller(ImagenController::class)->group(function () {
        Route::post('crear', 'crear');
        Route::post('actualizar', 'actualizar');
        Route::post('eliminar', 'eliminar');

    });
});
