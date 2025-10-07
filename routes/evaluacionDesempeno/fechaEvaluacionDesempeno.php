<?php

use App\Http\Modules\EvaluacionDesempeño\Th_Configuracion\Controllers\ThConfiguracionController;
use Illuminate\Support\Facades\Route;


Route::prefix('fecha-evaluacion-desempeno')->group(function (){
    Route::controller(ThConfiguracionController::class)->group(function (){
        Route::post('', 'crear');//->middleware('permission:thTipoPlantilla.crear');
    });
});
