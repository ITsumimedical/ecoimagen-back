<?php

use App\Http\Modules\Incidentes\Controllers\SeguimientoIncidenteController;
use Illuminate\Support\Facades\Route;

Route::prefix('seguimiento-incidentes')->group( function () {
    Route::controller(SeguimientoIncidenteController::class)->group(function (){
        Route::get('{id}','listar');//->middleware('permission:incidente.listar');
        Route::post('crear','crear');//->middleware('permission:incidente.crear');
    });
});
