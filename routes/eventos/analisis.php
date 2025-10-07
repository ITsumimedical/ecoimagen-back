<?php

use App\Http\Modules\Eventos\Analisis\Controllers\AnalisisEventoController;
use Illuminate\Support\Facades\Route;

Route::prefix('analisis-eventos')->group( function () {
    Route::controller(AnalisisEventoController::class)->group(function (){
        Route::post('crear','crear');//->middleware('permission:analisisEventoAdverso.crear');
        Route::put('/{id}','actualizar');
    });
});
