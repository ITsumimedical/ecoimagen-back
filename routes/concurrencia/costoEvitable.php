<?php

use App\Http\Modules\Concurrencia\Controllers\CostoEvitableController;
use Illuminate\Support\Facades\Route;


Route::prefix('costo-evitable')->group(function (){
    Route::controller(CostoEvitableController::class)->group(function (){
        Route::post('guardarCosto', 'guardarCosto');
        Route::post('listarCosto', 'listarCosto');
        Route::post('eliminarCosto', 'eliminarCosto');
    });
});
