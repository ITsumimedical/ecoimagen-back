<?php

use App\Http\Modules\interpretacionResultados\Controller\interpretacionResultadosController;
use Illuminate\Support\Facades\Route;

Route::prefix('interpretacionResultados', 'throttle:60,1')->group(function () {
    Route::controller(interpretacionResultadosController::class)->group(function () {
        Route::post('crear', 'crear');
    });
});
