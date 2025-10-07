<?php

use App\Http\Modules\RecomendacionesCups\Controllers\RecomendacionCupController;
use Illuminate\Support\Facades\Route;

Route::prefix('recomendacion-cups')->group(function()
{
    Route::controller(RecomendacionCupController::class)->group(function(){
        Route::post('listar', 'listar');//->middleware('permission:referencia.listar');
        Route::post('crear', 'crear');//->middleware('permission:referencia.crear');
        Route::post('consultar','consultar');
        Route::put('actualizar/{id}', 'actualizar');//->middleware('permission:referencia.actualizar');
        Route::put('cambiarEstado/{id}', 'actualizar');//->middleware('permission:referencia.cambiarEstado');

    });
});
