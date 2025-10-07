<?php

use App\Http\Modules\CampoHistorias\Controllers\CampoHistoriasController;
use Illuminate\Support\Facades\Route;

Route::prefix('campo-historia','throttle:60,1')->group(function (){
    Route::controller(CampoHistoriasController::class)->group(function (){
        Route::post('listar','listar');
        Route::post('crear','crear');
        Route::put('/{id}','actualizar');
    });
});
