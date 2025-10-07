<?php

use App\Http\Modules\EscalaDolor\Controller\EscalaDolorController;
use App\Http\Modules\Tanner\Controller\EscalaTannerController;
use Illuminate\Support\Facades\Route;


Route::prefix('tanner')->group(function (){
    Route::controller(EscalaTannerController::class)->group(function (){
        Route::post('crear', 'crear');
        Route::get('obtenerDatos/{afiliadoId}', 'obtenerDatos');
    });
});
