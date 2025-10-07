<?php

use App\Http\Modules\EvaluacionDesempeño\Calificacion_Competencia\Controllers\CalificacionCompetenciaController;
use Illuminate\Support\Facades\Route;


Route::prefix('calificacion-competencia')->group(function (){
    Route::controller(CalificacionCompetenciaController::class)->group(function (){
        Route::post('calificaciones', 'calificacion');//->middleware('permission:thTipoPlantilla.listar');
        Route::post('crear', 'crear');//->middleware('permission:thTipoPlantilla.crear');
    });
});
