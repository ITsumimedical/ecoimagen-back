<?php

use App\Http\Modules\Urgencias\SignosVitales\Controllers\SignosVitalesController;
use Illuminate\Support\Facades\Route;

Route::prefix('signos-vitales', 'throttle:60,1')->group(function () {
    Route::controller(SignosVitalesController::class)->group(function () {
        Route::post('crear', 'crear');
        Route::post('listarSignosVitales','listarSignosVitales');
        Route::put('/{id}','actualizar');
    });
});
