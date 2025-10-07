<?php

use App\Http\Modules\Concurrencia\Controllers\LineaTiempoConcurrenciaController;
use Illuminate\Support\Facades\Route;


Route::prefix('linea-tiempo-concurrencia')->group(function (){
    Route::controller(LineaTiempoConcurrenciaController::class)->group(function (){
        Route::post('listarLinea', 'listarLinea');
    });
});
