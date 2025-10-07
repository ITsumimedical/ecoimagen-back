<?php

use App\Http\Modules\TipoArchivo\Controllers\TipoArchivoController;
use Illuminate\Support\Facades\Route;

Route::prefix('tipo-archivo','throttle:60,1')->group(function (){
    Route::controller(TipoArchivoController::class)->group(function (){
        Route::get('listar','listar');
        Route::post('crear','crear');

    });
});
