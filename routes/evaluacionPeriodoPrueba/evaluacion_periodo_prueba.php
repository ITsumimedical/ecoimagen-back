<?php

use App\Http\Modules\EvaluacionesPeriodosPruebas\EvaluacionesPeriodosPruebas\Controllers\EvaluacionPeriodoPruebaController;
use Illuminate\Support\Facades\Route;

Route::prefix('evaluaciones-periodos-pruebas', 'throttle:60,1')->group(function () {
    Route::controller(EvaluacionPeriodoPruebaController::class)->group(function () {
        Route::get('listar', 'listar');//->middleware('permission:EvaluacionPeriodoPrueba.listar');
        Route::post('crear', 'crear');//->middleware('permission:EvaluacionPeriodoPrueba.crear');
        Route::put('/{id}', 'actualizar');//->middleware('permission:EvaluacionPeriodoPrueba.actualizar');
    });
});
