<?php

use App\Http\Modules\Oncologia\TomaProcedimiento\Controllers\TomaProcedimientoController;
use Illuminate\Support\Facades\Route;

Route::prefix('toma-procedimiento', 'throttle:60,1')->group(function (){
    Route::controller(TomaProcedimientoController::class)->group(function (){
        Route::get('listar', 'listar');//->middleware('permission:tomaProcedimiento.listar');
        Route::post('crear', 'crear');//->middleware('permission:tomaProcedimiento.crear');
        Route::put('/{id}', 'actualizar');//->middleware('permission:tomaProcedimiento.actualizar');
        Route::get('contador', 'contador');//->middleware('permission:tomaProcedimiento.actualizar');
        Route::get('listarPendientesAsignacion','listarPendientesPorCita');
        Route::post('actualizarEstado', 'actualizarEstado');//->middleware('permission:tomaProcedimiento.crear');
        Route::delete('eliminar/{id}', 'eliminar');
        Route::get('toma-muestras-realizadas','listarTomaMuestra');
    });
});
