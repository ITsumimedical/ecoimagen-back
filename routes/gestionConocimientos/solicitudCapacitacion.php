<?php

use App\Http\Modules\GestionConocimientos\Capacitaciones\Controllers\SolicitudCapacitacionController;
use Illuminate\Support\Facades\Route;

Route::prefix('solicitudes-capacitaciones')->group( function () {
    Route::controller(SolicitudCapacitacionController::class)->group(function (){
        Route::get('listar','listar');//->middleware('permission:solicitudCapacitacion.listar');
        Route::post('crear','crear');//->middleware('permission:solicitudCapacitacion.crear');
    });
});
