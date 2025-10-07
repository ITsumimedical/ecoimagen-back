<?php

use App\Http\Modules\EscalaDolor\Controller\EscalaDolorController;
use Illuminate\Support\Facades\Route;


Route::prefix('escalaDolor')->group(function (){
    Route::controller(EscalaDolorController::class)->group(function (){
        Route::post('crear', 'crear');
        Route::get('obtenerDatos/{afiliadoId}', 'obtenerDatos');
    });
});
