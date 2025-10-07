<?php

use App\Http\Modules\PortabilidadSalida\Controllers\PortabilidadsalidaController;
use Illuminate\Support\Facades\Route;

Route::prefix('portabilidad-salida', 'throttle:60,1')->group(function () {
    Route::controller(PortabilidadsalidaController::class)->group(function () {
        Route::post('listar', 'listar');
        Route::get('listarNovedades/{afiliado_id}/{portabilidad_salida_id}', 'listarNovedades');
        Route::post('crear', 'crear');
        Route::put('actualizar/{id}', 'actualizar');
        Route::post('inactivar/{id}', 'inactivar');
        Route::get('historial/{numero_cedula}', 'historial');
        Route::post('verificar-portabilidades-activas/{afiliado_id}', 'verificarPortabilidadesActivas');

    });
});
