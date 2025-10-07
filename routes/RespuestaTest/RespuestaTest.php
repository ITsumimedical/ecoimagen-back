<?php

use App\Http\Modules\respuestasTest\Controllers\RespuestasTestController;
use Illuminate\Support\Facades\Route;

Route::prefix('RespuestaTest', 'throttle:60,1')->group(function () {
    Route::controller(RespuestasTestController::class)->group(function() {
        Route::post('crearRespuesta','crearRespuesta');
    });
});
