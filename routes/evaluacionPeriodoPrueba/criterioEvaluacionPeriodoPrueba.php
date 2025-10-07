<?php

use App\Http\Modules\EvaluacionesPeriodosPruebas\CriteriosEvaluacionesPeriodosPruebas\Controllers\CriterioEvaluacionPeriodoPruebaController;
use Illuminate\Support\Facades\Route;

Route::prefix('criterios-evaluaciones-periodos-pruebas', 'throttle:60,1')->group(function () {
    Route::controller(CriterioEvaluacionPeriodoPruebaController::class)->group(function () {
        Route::get('listar', 'listar');//->middleware('permission:criterioEvaluacionPeriodoPrueba.listar');
        Route::post('crear', 'crear');//->middleware('permission:criterioEvaluacionPeriodoPrueba.crear');
        Route::put('/{id}', 'actualizar');//->middleware('permission:criterioEvaluacionPeriodoPrueba.actualizar');
    });
});
