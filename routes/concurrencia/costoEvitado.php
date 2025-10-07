<?php

use App\Http\Modules\Concurrencia\Controllers\CostoEvitadoController;
use Illuminate\Support\Facades\Route;


Route::prefix('costo-evitado')->group(function (){
    Route::controller(CostoEvitadoController::class)->group(function (){
        Route::post('guardarCosto', 'guardarCosto');
        Route::post('listarCosto', 'listarCosto');
        Route::post('eliminarCosto', 'eliminarCosto');
    });
});
