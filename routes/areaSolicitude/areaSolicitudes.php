<?php

use App\Http\Modules\AreaSolicitudes\Controllers\AreaSolicitudesController;
use Illuminate\Support\Facades\Route;

Route::prefix('area-solicitudes', 'throttle:60,1')->group(function () {
    Route::controller(AreaSolicitudesController::class)->group(function () {
        Route::post('crear', 'crear');
        Route::post('listar', 'listar');
        Route::put('/{id}','actualizar');
    });
});
