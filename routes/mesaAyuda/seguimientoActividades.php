<?php

use App\Http\Modules\MesaAyuda\SeguimientoActividades\Controllers\SeguimientoActividadesController;
use Illuminate\Support\Facades\Route;

Route::prefix('seguimiento-actividades', 'throttle:60,1')->group(function () {
    Route::controller(SeguimientoActividadesController::class)->group(function() {
        Route::get('listar' , 'listar');
        Route::post('crear' , 'crear');
        Route::put('{id}' , 'actualizar');
    });
});
