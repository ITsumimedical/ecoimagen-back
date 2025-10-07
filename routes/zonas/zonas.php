<?php

use App\Http\Modules\Zonas\Controllers\ZonaController;
use Illuminate\Support\Facades\Route;

Route::prefix('zonas' , 'throttle:60,1')->group( function () {
    Route::controller(ZonaController::class)->group(function(){
        Route::post('crear', 'crearZona')->middleware('permission:contrato.zona.crear');
        Route::get('listar', 'listarZonas')->middleware('permission:contrato.zona.listar');
        Route::put('actualizar/{id}', 'actualizarZona')->middleware('permission:contrato.zona.editar');
        Route::put('cambiarEstado/{id}', 'cambiarEstado')->middleware('permission:contrato.zona.editar');
    });
});
