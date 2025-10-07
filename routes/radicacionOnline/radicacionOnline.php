<?php

use App\Http\Modules\Solicitudes\RadicacionOnline\Controllers\RadicacionOnlineController;
use Illuminate\Routing\RouteRegistrar;
use Illuminate\Support\Facades\Route;

Route::prefix('radicacion-online')->group(function(){
    Route::controller(RadicacionOnlineController::class)->group(function(){
        Route::post('crearRadicacion','crearRadicacion');//->middleware('permission:solicitudes.crearRadicacion');
        Route::post('buscarPorFiltro','buscarPorFiltro');//->middleware('permission:solicitudes.buscarPorFiltro');
        Route::post('comentar','comentar');//->middleware('permission:solicitudes.comentar');
        Route::post('respuesta','respuesta');//->middleware('permission:solicitudes.respuesta');
        Route::post('asignar','asignar');//->middleware('permission:solicitudes.asignar');
        Route::post('buscarPorFiltroSolucioandas','buscarPorFiltroSolucioandas');//->middleware('permission:solicitudes.buscarPorFiltroSolucioandas');
        Route::post('buscarPendientesAsignadas','buscarPendientesAsignadas');//->middleware('permission:solicitudes.buscarPendientesAsignadas');
        Route::post('devolver','devolver');//->middleware('permission:solicitudes.devolver');
        Route::post('solucionadasAsignadas','solucionadasAsignadas');//->middleware('permission:solicitudes.solucionadasAsignadas');
        Route::post('buscarPendientes','buscarPendientes');//->middleware('permission:solicitudes.buscarPendientes');
        Route::post('solucionadasAdmin','solucionadasAdmin');//->middleware('permission:solicitudes.solucionadasAdmin');
        Route::post('informe','informe');//->middleware('permission:solicitudes.informe');
        Route::post('obtenerRadicadosPaciente','obtenerRadicadosPaciente');
        Route::post('comentarAutogestion','comentarAutogestion');//->middleware('permission:solicitudes.comentar');
        Route::get('cantidadPendientesTipo','cantidadPendientesTipo');
        Route::get('cantidadSolucionadasTipo','cantidadSolucionadasTipo');
        Route::post('listarSolicitudes','listarSolicitudes');
        Route::post('obtenerCantidadSolicitudesTipo','obtenerCantidadSolicitudesTipo');
        Route::post('listarSolicitudesAsignadas','listarSolicitudesAsignadas');
    });
});
