<?php

use App\Http\Modules\NotasEnfermeria\Controllers\NotasEnfermeriaController;
use Illuminate\Support\Facades\Route;

Route::prefix('nota_enfermeria', 'throttle:60,1')->group(function () {
    Route::controller(NotasEnfermeriaController::class)->group(function () {
        Route::post('listar', 'listar');
        Route::post('guardar', 'guardar');
    });
});
