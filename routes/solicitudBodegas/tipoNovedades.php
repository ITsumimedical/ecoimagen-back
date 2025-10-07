<?php

use App\Http\Modules\SolicitudBodegas\Controllers\TipoNovedadController;
use Illuminate\Support\Facades\Route;

Route::prefix('tipo-novedad', 'throttle:60,1')->group(function () {
    Route::controller(TipoNovedadController::class)->group(function () {
        Route::get('','listar');
    });
});
