<?php

use App\Http\Modules\Consultorios\Controllers\ConsultorioController;
use Illuminate\Support\Facades\Route;

Route::prefix('consultorios', 'throttle:60,1')->group(function () {
    Route::controller(ConsultorioController::class)->group(function (){
        Route::post('listar', 'listar');
        Route::post('crear', 'crear');
        Route::put('/{id}', 'actualizar');
        Route::post('listarRep', 'listarRep');
    });
});
