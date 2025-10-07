<?php

use App\Http\Modules\NovedadesAgendamientos\Controllers\NovedadAgendamientoController;
use Illuminate\Support\Facades\Route;

Route::prefix('novedad-agendamiento', 'throttle:60,1')->group(function (){
    Route::controller(NovedadAgendamientoController::class)->group(function (){
        Route::get('listar', 'listar');
        Route::post('crear', 'crear');
        Route::put('/{id}', 'actualizar');
    });
});
