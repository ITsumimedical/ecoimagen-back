<?php

use App\Http\Modules\PaqueteServicios\Controllers\PaqueteServicioController;
use Illuminate\Support\Facades\Route;

Route::prefix('paquete-servicio')->group(function () {
    Route::controller(PaqueteServicioController::class)->group(function () {
        Route::post('listar', 'listar');//->middleware('permission:paqueteServicio.listar');
        Route::post('', 'crear');//->middleware('permission:paqueteServicio.crear');
        Route::put('/{paquete_servicio}', 'actualizar');//->middleware('permission:paqueteServicio.actualizar');
        Route::put('/cambiar-estado/{paquete_servicio}', 'cambiarEstado');//->middleware('permission:paqueteServicio.actualizar');
        Route::get('/{id}', 'consultar');//->middleware('permission:paqueteServicio.listar');
        Route::post('agregarCup/{paquete_id}', 'agregarCup');
        Route::get('/listarCupsPorPaquete/{paquete_id}', 'listarCupsPorPaquete');
        Route::delete('eliminarCupPaquete', 'eliminarCupPaquete');
        Route::get('/listarCodigosPropiosPorPaquete/{paquete_id}', 'listarCodigosPropiosPorPaquete');
        Route::post('/agregarCodigoPropio/{paquete_id}','agregarCodigoPropio');
        Route::delete('eliminarCodigoPropioPaquete', 'eliminarCodigoPropioPaquete');
        Route::get('buscarPaqueteServicio/{codigoONombre}', 'buscarPaqueteServicio');
    });
});
