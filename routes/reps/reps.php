<?php

use Illuminate\Support\Facades\Route;
use App\Http\Modules\Reps\Controllers\RepsController;

Route::prefix('reps')->group(function () {
    Route::controller(RepsController::class)->group(function () {
        Route::get('/cups-prestador', 'cupsPrestador');
        Route::get('/parametrizacion-categoria-sede/{id}', 'parametrizacionCategoriaSede');
        Route::post('listar', 'listar'); //->middleware('permission:rep.listar');
        Route::get('', 'listarSinfiltro'); //->middleware('permission:rep.listar');
        Route::post('', 'crear'); //->middleware('permission:rep.crear');
        Route::put('/{id}', 'actualizar'); //->middleware('permission:rep.actualizar');
        Route::put('/cambiar-estado/{rep}', 'cambiarEstado'); //->middleware('permission:rep.actualizar');
        Route::get('/{reps}', 'consultar'); //->middleware('permission:rep.listar');
        Route::post('listarConfiltro', 'listarConfiltro'); //->middleware('permission:rep.listar');
        Route::post('listarPropias', 'listarPropias');
        Route::get('listarPropias/listar', 'listarPropias'); // ruta agredada solo para que salga en reportes
        Route::get('buscarRep/{codigoONombre}', 'buscarRep');
        Route::post('listarSedesUsuario', 'listarSedesUsuario');
        Route::post('listarFarmaciasSumi', 'listarFarmaciasSumi');
        Route::put('actualizar/{rep_id}/{prestador_id}', 'actualizarPrestador');
        Route::get('/listar-por-prestador/{prestador_id}', 'listarPorPrestador');
        Route::post('listar-por-entidad', 'listarPorEntidad');
        Route::post('guardar-parametrizacion-cup', 'guardarParametrizacionCup');
        Route::delete('eliminar-parametrizacion/{id}', 'eliminarParametrizacionCup');
        Route::post('consultarRep/{id}', 'consultarRep');
        Route::post('actualizarRep/{id}', 'actualizarReps');
        Route::post('listar-reps-direccionamiento-servicios', 'listarRepsDireccionamientoServicios');
        Route::post('listar-reps-direccionamiento-codigos-propios', 'listarRepsDireccionamientoCodigosPropios');
        Route::post('listar-reps-direccionamiento-medicamentos', 'listarRepsDireccionamientoMedicamentos');
        //RUTA PARA CONSULTAR REPS CACHADOS CON REDIS
        Route::get('listar/reps/cachados', 'listarRepsCachados');
        Route::get('propias/listarPropiasActivas', 'listarRepsPropiosActivos');
    });
});
