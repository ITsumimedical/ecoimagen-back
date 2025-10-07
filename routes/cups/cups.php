<?php

use App\Http\Modules\Cups\Controllers\CupController;
use Illuminate\Support\Facades\Route;

Route::prefix('cup', 'throttle:60,1')->group(function () {
    Route::controller(CupController::class)->group(function () {
        Route::get('', 'listar'); //->middleware(['permission:cups.listar']);
        Route::post('listar', 'listar'); //->middleware(['permission:cups.listar']);
        Route::post('', 'guardar'); //->middleware(['permission:cups.guardar']);
        Route::put('/{cup_id}', 'actualizar'); //->middleware(['permission:cups.guardar']);
        Route::put('/cambiar-estado/{cup}', 'cambiarEstado'); //->middleware(['permission:cups.guardar']);
        Route::get('consultar', 'consultar'); //->middleware(['permission:cups.listar']);
        Route::post('subirArchivo', 'subirArchivo'); //->middleware(['permission:cups.actualizarMasivo']);
        Route::post('tarbuscarCupsNombreifasPrestador', 'tarifasPrestador'); //->middleware(['permission:cups.listar']);
        Route::post('buscarCupsNombre', 'ConsultarCupsNombreCodigo'); //->middleware(['permission:cups.listar']);
        Route::get('BuscarCup/{nombre}', 'BuscarCup'); //->middleware(['permission:cups.listar']);
        Route::get('listarTiposEducacion', 'listarTiposEducacion'); //->middleware(['permission:cups.listar']);
        Route::post('asignarEntidades/{cup_id}', 'asignarEntidades');
        Route::get('obtenerEntidades/{cup_id}', 'obtenerCupEntidad');
        Route::post('guardar-parametros', 'guardarParametrosEntidad');
        Route::post('evaluar-requiere-diagnostico', 'evaluarRequiereDiagnostico');
        Route::get('listarCupsCita/{cita_id}', 'listarCupPorCita');
        Route::get('listar-entidades-cup/{cupId}', 'listarEntidadesCup');
        Route::post('agregar-entidades-cup', 'agregarEntidadesCup');
        Route::post('remover-entidades-cup', 'removerEntidadesCup');
        Route::get('listar-detalles-cup/{cupId}', 'listarDetallesCup');
        Route::get('listar-cup-entidad-por-cup/{cupId}', 'listarCupEntidadPorCup');
        Route::get('listar-detalles-cup-entidad/{cupEntidadId}', 'listarDetallesCupEntidad');
        Route::patch('editar-cup/{cupId}', 'editarCup');
        Route::patch('editar-cup-entidad/{cupEntidadId}', 'editarCupEntidad');
        Route::get('listar-familias-cup/{cupId}', 'listarFamiliasCup');
    });
});
