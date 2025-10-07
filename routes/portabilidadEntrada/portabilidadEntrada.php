<?php

use App\Http\Modules\PortabilidadEntrada\Controllers\PortabilidadEntradaController;
use Illuminate\Support\Facades\Route;

Route::prefix('portabilidad-entrada', 'throttle:60,1')->group(function () {
    Route::controller(PortabilidadEntradaController::class)->group(function () {
        Route::post('listarPortabilidad', 'listarPortabilidad');
        Route::post('crear', 'crear');//->middleware(['permission:portabilidadEntrada.crear']);
        Route::put('actualizar/{id}', 'actualizar');
        Route::post('inactivar/{id}', 'inactivar');
        Route::get('listarNovedadesEntrada/{afiliado_id}/{portabilidad_entrada_id}', 'listarNovedadesEntrada');
        Route::get('historial/{numero_cedula}', 'historial');
        Route::post('portabilidades-activas/{afiliado_id}', 'verificarPortabilidadesActivas');

    });
});
