<?php

use App\Http\Modules\RecomendacionesConsulta\Controllers\recomendacionesConsultaController;
use Illuminate\Support\Facades\Route;

Route::prefix('recomendacionesConsulta')->group( function () {
    Route::controller(recomendacionesConsultaController::class)->group(function (){
        Route::post('crear','crear');
        Route::get('listar/{consulta_id}', 'listar');
    });
});
