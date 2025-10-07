<?php

use App\Http\Modules\TipoSolicitudBodegas\Controllers\TipoSolicitudBodegasController;
use Illuminate\Support\Facades\Route;

Route::prefix('tipo-solicitud-bodegas', 'throttle:60,1')->group(function () {
    Route::controller(TipoSolicitudBodegasController::class)->group(function() {
        Route::get('listar', 'listar');//->middleware(['permission:tipoSolicitudBodegas.listar']);
    });
});
