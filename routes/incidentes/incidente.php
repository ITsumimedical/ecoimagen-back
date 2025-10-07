<?php

use App\Http\Modules\Incidentes\Controllers\IncidenteController;
use Illuminate\Support\Facades\Route;

Route::prefix('incidentes')->group( function () {
    Route::controller(IncidenteController::class)->group(function (){
        Route::get('listar','listar');//->middleware('permission:incidente.listar');
        Route::post('crear','crear');//->middleware('permission:incidente.crear');
        Route::put('/{id}','actualizar');//->middleware('permission:incidente.actualizar');
        Route::put('/cerrar/{incidente}', 'cerrar');//->middleware('permission:incidente.cerrar');
    });
});
