<?php

use App\Http\Modules\Historia\estratificacionFindrisks\Controllers\EstratificacionFindrisksController;
use Illuminate\Support\Facades\Route;

Route::prefix('estratificacion-findrisks', 'throttle:60,1')->group(function (){
    Route::controller(EstratificacionFindrisksController::class)->group(function (){
        Route::post('guardar', 'guardar');
        Route::post('listarEstratificacion', 'listarEstratificacion');
        Route::post('crear', 'crear');
    });
});
