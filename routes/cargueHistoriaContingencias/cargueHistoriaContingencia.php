<?php

use App\Http\Modules\CargueHistoriaContingencia\Controllers\CargueHistoriaContingenciaController;
use Illuminate\Support\Facades\Route;

Route::prefix('cargue-historia-contingencia','throttle:60,1')->group(function (){
    Route::controller(CargueHistoriaContingenciaController::class)->group(function (){
        Route::post('crear','crear');

    });
});
