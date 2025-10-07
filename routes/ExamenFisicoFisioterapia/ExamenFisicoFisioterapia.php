<?php

use App\Http\Modules\ExamenFisicoFisioterapia\Controller\ExamenFisicoFisioterapiaController;
use Illuminate\Support\Facades\Route;

Route::prefix('examenFisioterapia', 'throttle:60,1')->group(function () {
    Route::controller(ExamenFisicoFisioterapiaController::class)->group(function() {
        Route::post('crear', 'crear');
    });
});
