<?php

use App\Http\Modules\ServiciosTH\Controllers\ServicioThController;
use Illuminate\Support\Facades\Route;

Route::prefix('servicio-th')->group( function () {
    Route::controller(ServicioThController::class)->group(function (){
        Route::get('listar','listar')           ;//->middleware('permission:servicioTh.listar');
        Route::post('crear','crear')            ;//->middleware('permission:servicioTh.crear');
        Route::put('/{id}','actualizar')        ;//->middleware('permission:servicioTh.actualizar');
        Route::get('exportar', 'exportar');
    });
});
