<?php

use App\Http\Modules\EvaluacionDesempeño\th_pilares\Controllers\ThPilarController;
use Illuminate\Support\Facades\Route;


Route::prefix('th-pilares')->group(function (){
    Route::controller(ThPilarController::class)->group(function (){
        Route::get('', 'listar');//->middleware('permission:thTipoPlantilla.listar');
        Route::post('crear', 'crear');//->middleware('permission:thTipoPlantilla.crear');
        Route::put('/{id}', 'actualizar');//->middleware('permission:thTipoPlantilla.actualizar');
    });
});
