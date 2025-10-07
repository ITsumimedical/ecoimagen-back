<?php

use App\Http\Modules\RespuestasTutelas\Controllers\RespuestaTutelaController;
use Illuminate\Support\Facades\Route;

Route::prefix('respuesta', 'throttle:60,1')->group(function () {
    Route::controller(RespuestaTutelaController::class)->group(function() {
        Route::post('listarRespuestas', 'listarRespuestas');
        Route::post('','crear');
        Route::put('/{respuesta}','actualizar');
        Route::post('consultarAdjuntos' , 'consultarAdjuntos');
    });
});
