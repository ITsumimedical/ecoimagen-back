<?php

use App\Http\Modules\Beneficios\Controllers\BeneficioController;
use Illuminate\Support\Facades\Route;

Route::prefix('beneficios')->group( function () {
    Route::controller(BeneficioController::class)->group(function (){
        Route::get('listar','listar');//->middleware('permission:beneficio.listar');
        Route::post('crear','crear');//->middleware('permission:beneficio.crear');
        Route::put('/{id}','actualizar');//->middleware('permission:beneficio.actualizar');
    });
});
