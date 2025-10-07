<?php

use App\Http\Modules\ParametrizacionPlanCuidados\Controllers\ParametrizacionPlanCuidadoController;
use Illuminate\Support\Facades\Route;

Route::prefix('plan-cuidado', 'throttle:60,1')->group(function () {
    Route::controller(ParametrizacionPlanCuidadoController::class)->group(function () {
        Route::post('crear/{id}', 'crear');
        Route::get('listar', 'listar');
    });
});
