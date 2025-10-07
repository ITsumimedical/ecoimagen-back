<?php

use App\Http\Modules\Concurrencia\Controllers\EventosIngresosConcurrenciaController;
use Illuminate\Support\Facades\Route;


Route::prefix('evento-ingreso-concurrencia')->group(function (){
    Route::controller(EventosIngresosConcurrenciaController::class)->group(function (){
        Route::post('guardarEvento', 'guardarEvento');
        Route::post('listarEvento', 'listarEvento');
        Route::post('eliminarEvento', 'eliminarEvento');
    });
});
