<?php

use App\Http\Modules\Solicitudes\TipoSolicitudEntidad\Controllers\TipoSolicitudEntidadController;
use Illuminate\Support\Facades\Route;

Route::prefix('tipo-solicitud-entidad', 'throttle:60,1')->group(function(){
    Route::controller(TipoSolicitudEntidadController::class)->group(function(){
        Route::post('listar','listar');
        Route::post('inactivar','inactivar');
    });
});
