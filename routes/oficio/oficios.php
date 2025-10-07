<?php

use App\Http\Modules\Epidemiologia\Controllers\OficioController;
use Illuminate\Support\Facades\Route;

Route::prefix('oficio', 'throttle:60,1')->group(function () {
    Route::controller(OficioController::class)->group(function (){
        Route::post('listarOficiosNombre', 'listarOficiosNombre');
    });
});
