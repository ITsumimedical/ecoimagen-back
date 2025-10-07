<?php

use App\Http\Modules\Eventos\GestionEventos\Controllers\GestionEventoController;
use Illuminate\Support\Facades\Route;

Route::prefix('gestion-eventos')->group( function () {
    Route::controller(GestionEventoController::class)->group(function (){
        Route::post('crear','crear');//->middleware('permission:analisisEventoAdverso.crear');
        Route::get('historicoGestionEvento/{id}', 'historicoGestionEvento');
    });
});
