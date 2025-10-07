<?php

use App\Http\Modules\TipoServicioTutelas\Controllers\TipoServicioTutelaController;
use Illuminate\Support\Facades\Route;

Route::prefix('tipo-servicio', 'throttle:60,1')->group(function () {
    Route::controller(TipoServicioTutelaController::class)->group(function() {
        Route::get('', 'listar')                ;//->middleware(['permission:tipoServicio.listar']);
        Route::post('','guardar')               ;//->middleware(['permission::tipoServicio.guardar']);
        Route::put('/{servicio}','actualizar')  ;//->middleware(['permission::tipoServicio.actualizar']);
    });
});
