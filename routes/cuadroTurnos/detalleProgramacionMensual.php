<?php

use App\Http\Modules\CuadroTurnos\DetalleProgramacionMensual\Controllers\DetalleProgramacionMensualController;
use Illuminate\Support\Facades\Route;

Route::prefix('detalles-programaciones-mensuales')->group( function () {
    Route::controller(DetalleProgramacionMensualController::class)->group(function (){
        Route::get('listar','listar');//->middleware('permission:programacionMensual.listar');
        Route::post('crear','crear');//->middleware('permission:programacionMensual.crear');
        Route::put('/{id}','actualizar');//->middleware('permission:programacionMensual.actualizar');
    });
});
