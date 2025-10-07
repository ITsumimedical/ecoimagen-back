<?php

use App\Http\Modules\TipoCitas\Controllers\TipoCitaController;
use Illuminate\Support\Facades\Route;

Route::prefix('tipo-citas', 'throttle:60,1')->group(function () {
    Route::controller(TipoCitaController::class)->group(function (){
        Route::get('listar', 'listar')     ;//->middleware(['permission:tipoCita.listar']);
        Route::post('crear', 'crear')       ;//->middleware(['permission:tipoCita.crear']);
        Route::put('/{id}', 'actualizar')   ;//->middleware(['permission:tipoCita.actualizar']);
    });
});
