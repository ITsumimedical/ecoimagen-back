<?php

use App\Http\Modules\testSrq\Controllers\SrqController;
use Illuminate\Support\Facades\Route;

Route::prefix('srq', 'throttle:60,1')->group(function () {
    Route::controller(SrqController::class)->group(function () {
        Route::post('crear','crear');
        Route::get('obtenerDatos/{afiliadoId}', 'obtenerDatos');
    });
});
