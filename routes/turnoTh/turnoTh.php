<?php

use App\Http\Modules\TurnosTH\Controllers\TurnoThController;
use Illuminate\Support\Facades\Route;

Route::prefix('turno-th')->group( function () {
    Route::controller(TurnoThController::class)->group(function (){
        Route::get('listar','listar')       ;//->middleware(['permission:turnoTh.listar']);
        Route::post('crear','crear')        ;//->middleware(['permission:turnoTh.crear']);
        Route::put('/{id}','actualizar')    ;//->middleware(['permission:turnoTh.actualizar']);
        Route::get('exportar', 'exportar')  ;//->middleware(['permission:turnoTh.exportar']);
    });
});
