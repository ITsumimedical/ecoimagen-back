<?php

use App\Http\Modules\TipoHistorias\Controllers\TipoHistoriaController;
use Illuminate\Support\Facades\Route;

Route::prefix('tipo-historia')->group(function () {
    Route::controller(TipoHistoriaController::class)->group(function (){
        Route::get('','listar');
        Route::post('crear-tipo-historia','crearTipoHistoria');
        Route::put('actualizar-tipo-historia/{id}','actualizar');
        Route::post('agregar-componentes-tipo-historia','agregarComponentesTipoHistoria');
        Route::get('listar-componentes-tipo-historia/{id}','listarComponentesTipoHistoria');
    });
});
