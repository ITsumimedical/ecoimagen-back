<?php

use App\Http\Modules\Historia\estratificacionFramingham\Controllers\EstratificacionFraminghamsController;
use Illuminate\Support\Facades\Route;

Route::prefix('estratificacion-framingham', 'throttle:60,1')->group(function (){
    Route::controller(EstratificacionFraminghamsController::class)->group(function (){
        Route::post('guardar', 'guardar');
        Route::post('listarEstratificacion', 'listarEstratificacion');
        Route::post('crear', 'crear');
    });
});
