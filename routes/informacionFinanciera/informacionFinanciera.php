<?php

use App\Http\Modules\InformacionFinanciera\Controllers\InformacionFinancieraController;
use Illuminate\Support\Facades\Route;

Route::prefix('informacion-financiera', 'throttle:60,1')->group(function () {
    Route::controller(InformacionFinancieraController::class)->group(function () {
        Route::post('crear', 'crear')       ;
    });
});
