<?php

use App\Http\Modules\InformacionCuidador\Controllers\InformacionCuidadorController;
use Illuminate\Support\Facades\Route;

Route::prefix('informacionCuidadors')->group(function(){
    Route::controller(InformacionCuidadorController::class)->group(function(){
        Route::get('listar', 'listarInformacionCuidadors');//->middleware('permission:informacionCuidador.listar');
        Route::post('crear', 'crearInformacionCuidador');//->middleware('permission:informacionCuidador.crear');
        Route::put('actualizar/{id}', 'actualizarInformacionCuidador');//->middleware('permission:informacionCuidador.actualizar');
    });
});
