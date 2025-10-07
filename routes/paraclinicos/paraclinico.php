<?php

use App\Http\Modules\Historia\Paraclinicos\Controllers\ParaclinicoController;
use Illuminate\Support\Facades\Route;

Route::prefix('paraclinico', 'throttle:60,1')->group(function () {
    Route::controller(ParaclinicoController::class)->group(function (){
        Route::post('guardar', 'guardar');
        Route::post('listar', 'listar');
    });
});
