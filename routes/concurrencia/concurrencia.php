<?php

use App\Http\Modules\Concurrencia\Controllers\ConcurrenciaController;
use Illuminate\Support\Facades\Route;


Route::prefix('concurrencia')->group(function (){
    Route::controller(ConcurrenciaController::class)->group(function (){
        Route::post('crearIngreso', 'crearIngreso');
        Route::post('crearConcurrencia', 'crearConcurrencia');
        Route::post('crearSeguimiento', 'crearSeguimiento');
        Route::post('ordenamiento', 'ordenamiento');
        Route::put('actualizar', 'actualizarIngreso');
        Route::put('actualizarSeguimiento', 'actualizarSeguimiento');
        Route::put('actualizarConcurrencia', 'actualizarConcurrencia');
        Route::post('complementar', 'complemento');
        Route::post('eliminarComplementos', 'eliminarComplementos');
        Route::post('eliminarOrdenamientos', 'eliminarOrdenamientos');
        Route::get('contador', 'contadorSeguimiento');
        Route::post('listar', 'listarConcurrencia');
        Route::get('listarConcurrenciasIngreso/{id}', 'listarConcurrenciasIngreso');
        Route::post('listarIngreso', 'listarIngreso');
        Route::get('/complemento/{id}', 'listarComplementos');
        Route::get('/ordenamiento/{id}', 'listarOrdenamientos');
        Route::get('/seguimiento/{id}', 'listarSeguimiento');
        Route::post('listarAlta', 'listarAlta');
        Route::post('reabrir', 'reabrir');
    });
});
