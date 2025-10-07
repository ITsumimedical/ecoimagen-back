<?php

use Illuminate\Support\Facades\Route;
use App\Http\Modules\DemandaInsatisfecha\Controllers\DemandaInsatisfechaController;

Route::prefix('demanda-insatisfecha', 'throttle:60,1')->group(function (){
    Route::controller(DemandaInsatisfechaController::class)->group(function (){
        Route::post('crear', 'crear');
        Route::get('listar/{afiliado_id}', 'listar');
    });
});
