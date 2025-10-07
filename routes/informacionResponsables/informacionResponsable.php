<?php

use App\Http\Modules\InformacionResponsables\Controllers\InformacionResponsableController;
use Illuminate\Support\Facades\Route;

Route::prefix('informacionResponsables')->group(function(){
    Route::controller(InformacionResponsableController::class)->group(function(){
        Route::get('listar', 'listarInformacionResponsables');//->middleware('permission:informacionResponsable.listar');
        Route::post('crear', 'crearInformacionResponsable');//->middleware('permission:informacionResponsable.crear');
        Route::put('actualizar/{id}', 'actualizarInformacionResponsable');//->middleware('permission:informacionResponsable.actualizar');
    });
});
