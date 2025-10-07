<?php

use App\Http\Modules\NovedadesAfiliados\Controllers\NovedadAfiliadoController;
use Illuminate\Support\Facades\Route;

Route::prefix('novedad-afiliado', 'throttle:60,1')->group(function () {
    Route::controller(NovedadAfiliadoController::class)->group(function () {
        Route::get('listar', 'listar');
        Route::post('crear/{afiliado_id}', 'crear');
        Route::put('/{id}', 'actualizar');
        Route::post('novedadAfiliado/{afiliado_id}', 'novedadAfiliado');
        Route::get('buscarNovedadPorId/{novedad_id}', 'buscarNovedadPorId');
    });
});
