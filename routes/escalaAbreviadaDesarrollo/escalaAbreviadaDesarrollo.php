<?php

use Illuminate\Support\Facades\Route;
use App\Http\Modules\Historia\EscalaAbreviadaDesarrollos\Controllers\EscalaAbreviadaDesarrolloController;


Route::prefix('escala-abreviada-desarrollo')->group(function (){
    Route::controller(EscalaAbreviadaDesarrolloController::class)->group(function (){
        Route::post('listar', 'listarEscalaAbreviada');
        Route::post('convertirPd', 'convertirPd');
    });
});
