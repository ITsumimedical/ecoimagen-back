<?php

use App\Http\Modules\Fias\Descarga\Controllers\DescargaFiasController;
use Illuminate\Support\Facades\Route;

Route::prefix('descarga-fias')->group( function () {
    Route::controller(DescargaFiasController::class)->group(function (){
        Route::post('descargar','descargar');
    });
});
