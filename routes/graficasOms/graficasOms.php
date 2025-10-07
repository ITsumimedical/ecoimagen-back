<?php

use Illuminate\Support\Facades\Route;
use App\Http\Modules\GraficasOms\Controllers\GraficasOmsController;

Route::prefix('graficas-oms')->group(function () {
    Route::controller(GraficasOmsController::class)->group(function () {
        Route::post('generarGraficaPesoTalla','generarGraficaPesoTalla');
        Route::post('generarGraficaTallaEdad', 'generarGraficaTallaEdad');
        Route::post('generarGraficaPerimetroCefalico', 'generarGraficaPerimetroCefalico');
        Route::post('generarGraficaIMC', 'generarGraficaIMC');
        Route::post('generarGraficaPesoEdad', 'generarGraficaPesoEdad');
    });
});