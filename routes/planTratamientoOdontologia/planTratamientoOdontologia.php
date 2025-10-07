<?php

use App\Http\Modules\PlanTratamiento\Controllers\planTratamientoController;
use Illuminate\Support\Facades\Route;

Route::prefix('planTratamiento', 'throttle:60,1')->group(function () {
    Route::controller(planTratamientoController::class)->group(function () {
        Route::post('crear', 'crear');
    });
});
