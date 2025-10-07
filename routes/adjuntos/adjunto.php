<?php

use App\Http\Modules\Adjuntos\Controller\AdjuntoController;
use Illuminate\Support\Facades\Route;

Route::prefix('adjuntos', 'throttle:60,1')->group(function () {
    Route::controller(AdjuntoController::class)->group(function() {
        Route::post('get','get');//->middleware(['permission:adjunto.guardar']);
        Route::post('getType','getType');//->middleware(['permission:adjunto.actualizar']);
        Route::post('generar-url-descarga-s3','generarUrlTemporalDescargarArchivo');
    });
});
