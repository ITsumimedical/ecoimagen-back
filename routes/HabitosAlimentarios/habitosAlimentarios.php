<?php

use App\Http\Modules\HabitosAlimentarios\Controllers\HabitosAlimentariosController;
use Illuminate\Support\Facades\Route;

Route::prefix('habitosAlimentarios', 'throttle:60,1')->group(function () {
    Route::controller(HabitosAlimentariosController::class)->group(function () {
        Route::post('crearHabitos','crearHabitos');
    });
});
