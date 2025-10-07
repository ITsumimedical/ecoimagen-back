<?php

use App\Http\Modules\EvaluacionDesempeño\evaluaciones_desempeños\Controllers\EvaluacionesDesempenoController;
use Illuminate\Support\Facades\Route;


Route::prefix('evaluacion-desempeno')->group(function (){
    Route::controller(EvaluacionesDesempenoController::class)->group(function (){
        Route::post('', 'consultaSiTieneEvaluacionOcrearleUna');//->middleware('permission:thTipoPlantilla.crear');
        Route::post('finalizar-evaluacion/{id}', 'finalizarEvaluacion');//->middleware('permission:finalizar.evaluacion');
        Route::get('plantilla', 'plantillas');//->middleware('permission:thTipoPlantilla.crear');
        Route::post('miPlantilla/{plantilla_id}', 'miPlantilla');//->middleware('permission:thTipoPlantilla.crear');
        Route::put('/{id}', 'actualizar');//->middleware('permission:thTipoPlantilla.actualizar');
        Route::get('printfpdf/{id}', 'printfpdf');//->middleware('permission:thTipoPlantilla.actualizar');
    });
});
