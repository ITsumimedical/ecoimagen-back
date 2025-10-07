<?php

use App\Http\Modules\EvaluacionesPeriodosPruebas\PlantillasEvaluacionesPeriodosPruebas\Controllers\PlantillaEvaluacionPeriodoPruebaController;
use Illuminate\Support\Facades\Route;

Route::prefix('plantillas-evaluaciones-periodos-pruebas', 'throttle:60,1')->group(function () {
    Route::controller(PlantillaEvaluacionPeriodoPruebaController::class)->group(function () {
        Route::get('listar', 'listar');//->middleware('permission:plantillasEvaluacionPeriodoPrueba.listar');
        Route::post('crear', 'crear');//->middleware('permission:plantillasEvaluacionPeriodoPrueba.crear');
        Route::put('/{id}', 'actualizar');//->middleware('permission:plantillasEvaluacionPeriodoPrueba.actualizar');
    });
});
