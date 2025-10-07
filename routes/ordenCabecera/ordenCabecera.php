<?php

use App\Http\Modules\OrdenCabecera\Controllers\OrdenCabeceraController;
use Illuminate\Support\Facades\Route;

Route::prefix('orden-cabecera', 'throttle:60,1')->group(function () {
    Route::controller(OrdenCabeceraController::class)->group(function () {
        Route::post('listarLaboratorios', 'listarLaboratorios');
        Route::post('resultados', 'resultados');

    });
});
