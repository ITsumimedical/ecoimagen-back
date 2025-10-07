<?php

use App\Http\Modules\ActividadInternacional\Controllers\ActividadInternacionalController;
use Illuminate\Support\Facades\Route;

Route::prefix('actividad-internacional', 'throttle:60,1')->group(function () {
    Route::controller(ActividadInternacionalController::class)->group(function () {
        Route::post('crear', 'crear')       ;


    });
});
