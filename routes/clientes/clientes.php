<?php

use App\Http\Modules\Clientes\Controllers\ClienteController;
use Illuminate\Support\Facades\Route;
use App\Http\Modules\ClienteMesaAyuda\Controllers\ClienteMesaAyudaController;

Route::prefix('clientes', 'throttle:60,1')->group(function () {
    Route::controller(ClienteController::class)->group(function () {
        Route::get('listar-clientes', 'listarClientes');
        Route::put('cambiarEstado/{clienteId}', 'cambiarEstado');
        Route::post('crearClientes', 'crearClientes');
        Route::put('actualizar/{id}', 'actualizarClientes');

    });
});
