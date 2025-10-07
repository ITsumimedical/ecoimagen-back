<?php

use App\Http\Modules\Eventos\TipoEventos\Controllers\TipoEventoController;
use Illuminate\Support\Facades\Route;

Route::prefix('tipos-eventos')->group( function () {
    Route::controller(TipoEventoController::class)->group(function (){
        Route::get('listar','listar');//->middleware('permission:tipoEvento.listar');
        Route::get('{clasificacion_area_id}', 'listarConClasiArea');//->middleware('permission:tipoEvento.listar');
        Route::post('crear','crear');//->middleware('permission:tipoEvento.crear');
        Route::put('/{id}','actualizar');//->middleware('permission:tipoEvento.actualizar');
    });
});
