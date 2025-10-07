<?php

use App\Http\Modules\EstadoAnimoComportamiento\Controller\EstadoAnimoComportamientoController;
use Illuminate\Support\Facades\Route;

Route::prefix('estadoAnimo', 'throttle:60,1')->group(function (){
    Route::controller(EstadoAnimoComportamientoController::class)->group(function (){
        Route::post('crear', 'crear');
        Route::get('obtenerDatos/{afiliadoId}', 'obtenerDatos');
    });
});
