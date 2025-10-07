<?php

use App\Http\Modules\CambioAgendas\Controllers\CambioAgendaController;
use Illuminate\Support\Facades\Route;

Route::prefix('cambio-agenda')->group(function () {
    Route::controller(CambioAgendaController::class)->group(function () {
        Route::post('crear','crear');//->middleware('permission:agenda.guardar');
        Route::get('{id}','listar');//->middleware('permission:agenda.listar');
    });
});
