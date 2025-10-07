<?php

use App\Http\Modules\DeclaracionFondos\Controllers\DeclaracionFondoController;
use Illuminate\Support\Facades\Route;

Route::prefix('declaracion-fondo', 'throttle:60,1')->group(function () {
    Route::controller(DeclaracionFondoController::class)->group(function () {
        Route::post('crear', 'crear')       ;


    });
});
