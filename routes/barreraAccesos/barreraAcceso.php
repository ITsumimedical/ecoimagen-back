<?php

use App\Http\Modules\BarreraAccesos\Controllers\BarreraAccesoController;
use Illuminate\Support\Facades\Route;

Route::prefix('barrera-acceso')->group( function () {
    Route::controller(BarreraAccesoController::class)->group(function (){
        Route::post('listar','listar');//->middleware('permission:asegurador.barreraAcceso.listar');
        Route::post('crear','crear');//->middleware('permission:asegurador.barreraAcceso.crear');
        Route::put('actualizar/{barrera_id}','actualizar');//->middleware('permission:asegurador.barreraAcceso.actualizar');
        Route::post('reporte','exportar');//->middleware('permission:asegurador.barreraAcceso.exportar');
        Route::post('listar-barreas-pendientes', 'listarBarrerasPendientes');
        Route::post('listar-barreras-asignadas', 'listarBarrerasAsignadas');
        Route::post('listar-barreras-presolucionadas', 'listarBarrerasPresolucionadas');
        Route::post('listar-barreras-solucionadas-anuladas', 'listarBarrerasSolucionadasAnuladas');
        Route::post('listar-barreras-registradas-user', 'listarBarrerasRegistradasUser');
        Route::post('listar-barreras-asignadas-user', 'listarBarrerasAsignadasUser');
        Route::post('listar-barreras-solucionadas-anuladas-user', 'listarBarrerasSolucionadasAnuladasUser');
        Route::put('solucionar-anular-barrera-acceso/{id}', 'solucionarAnularBarreraAcceso');
        Route::post('asignar-area-responsable', 'asignarAreaResponsable');
        Route::post('reasignar-area-responsable', 'reasignarAreaResponsable');
    });
});
