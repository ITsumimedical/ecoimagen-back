<?php

use App\Http\Modules\Eventos\EventosAsignados\Controllers\EventoAsignadoController;
use Illuminate\Support\Facades\Route;

Route::prefix('evento-asignado')->group( function () {
    Route::controller(EventoAsignadoController::class)->group(function (){
        Route::get('{id}','listar');//->middleware('permission:eventoAdverso.crear');
    });
});
