<?php

use App\Http\Modules\Camas\Controllers\CamaController;
use App\Http\Modules\Camas\Controllers\NovedadCamaController;
use Illuminate\Support\Facades\Route;

Route::prefix('novedad-cama')->group( function () {
    Route::controller(NovedadCamaController::class)->group(function (){
        Route::post('crear','crear');
    });
});
