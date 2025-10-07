<?php

use App\Http\Modules\Urgencias\NotaEnfermeria\Controllers\NotasEnfermeriaUrgenciasController;
use Illuminate\Support\Facades\Route;

Route::prefix('nota-enfermeria-urgencias', 'throttle:60,1')->group(function () {
    Route::controller(NotasEnfermeriaUrgenciasController::class)->group(function () {
        Route::post('crear', 'crear');
        Route::post('listarNota','listarNota');
        Route::put('/{id}','actualizar');
    });
});
