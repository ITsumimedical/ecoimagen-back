<?php

use App\Http\Modules\Eventos\EventosAdversos\Controllers\EventoAdversoController;
use Illuminate\Support\Facades\Route;

Route::prefix('eventos-adversos')->group( function () {
    Route::controller(EventoAdversoController::class)->group(function (){
        Route::get('contadores-eventos', 'contadoresEventosAdversos')->middleware('permission:eventoAdverso.listar');
        Route::post('listar','listar');//->middleware('permission:eventoAdverso.listar');
        Route::post('listarEventosEstado/','listarEventosEstado');//->middleware('permission:eventoAdverso.listar');
        Route::get('listarEventosAfiliado/{id}','listarEventosAfiliado');//->middleware('permission:eventoAdverso.listar');
        Route::post('crear','crear');//->middleware('permission:eventoAdverso.crear');
        Route::post('reporte','reporte');//->middleware('permission:eventoAdverso.listar');
        Route::post('cerrar','cerrarEventoAdverso');//->middleware('permission:eventoAdverso.listar');
        Route::put('/{id}','actualizar');//->middleware('permission:eventoAdverso.actualizar');
        Route::get('printfpdf/{id}', 'printfpdf');//->middleware('permission:eventoAdverso.listar');
        Route::post('devolverEvento', 'devolverEvento');
        Route::post('asignar-evento-adverso', 'asignarEvento');
        Route::get('listar-eventos-id/{id}', 'listarEventosId');
        Route::post('actualizar-estado', 'actualizarEstado');
        Route::post('listar-seguimiento-iaas', 'listarSeguimientoIAAS');
        Route::post('descargar-seguimiento-iaas', 'descargarSeguimientoIAAS');
    });
});
