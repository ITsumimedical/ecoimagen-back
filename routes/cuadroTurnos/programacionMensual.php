<?php

use App\Http\Modules\CuadroTurnos\ProgramacionMensual\Controllers\ProgramacionMensualController;
use Illuminate\Support\Facades\Route;

Route::prefix('programaciones-mensuales')->group( function () {
    Route::controller(ProgramacionMensualController::class)->group(function (){
        Route::get('listar','listar');//->middleware('permission:programacionMensual.listar');
        Route::post('crear','crear');//->middleware('permission:programacionMensual.crear');
        Route::put('/{id}','actualizar');//->middleware('permission:programacionMensual.actualizar');
    });
});
