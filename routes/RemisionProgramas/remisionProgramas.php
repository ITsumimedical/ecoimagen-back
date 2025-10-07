<?php

use App\Http\Modules\RemisionProgramas\Controllers\RemisionProgramasController;
use Illuminate\Support\Facades\Route;

Route::prefix('remisionProgramas')->group(function()
{
    Route::controller(RemisionProgramasController::class)->group(function(){
        Route::post('crearRemision', 'crearRemision');
        Route::post('listarPorAfiliado', 'listarPorAfiliado');
        Route::delete('eliminarRemision/{id}', 'eliminarRemision');
    });
});
