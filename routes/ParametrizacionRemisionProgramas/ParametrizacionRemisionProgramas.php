<?php

use App\Http\Modules\ParametrizacionRemisionProgramas\Controller\ParametrizacionRemisionProgramasController;
use Illuminate\Support\Facades\Route;

Route::prefix('parametrizacionRemisionProgramas', 'throttle:60,1')->group(function () {
    Route::controller(ParametrizacionRemisionProgramasController::class)->group(function () {
        Route::post('crear', 'crear');
        Route::get('listar', 'listar');
        Route::post('listarPorEdadYSexo', 'listarPorEdadYSexo');
        Route::put('actualizar/{id}', 'actualizar');
    });
});
