<?php

use App\Http\Modules\IngresoDomiciliarios\Controllers\IngresoDomiciliarioController;
use Illuminate\Support\Facades\Route;

Route::prefix('ingresoDomiciliarios')->group(function()
{
    Route::controller(IngresoDomiciliarioController::class)->group(function()
    {
        Route::post('crear', 'crearIngresoDomiciliario');//->middleware('permission:ingresoDomiciliario.crear');
        Route::get('listar', 'listarIngresoDomiciliarios');//->middleware('permission:ingresoDomiciliario.listar');
        Route::put('actualizar/{id}', 'actualizarIngresoDomiciliario');//->middleware('permission:ingresoDomiciliario.actualizar');
        Route::put('estado/{id}', 'cambiarEstadoIngresoDomiciliario');//->middleware('permission:ingresoDomiciliario.estado');
    });
});
