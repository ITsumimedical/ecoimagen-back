<?php

use App\Http\Modules\FuncionRenal\Controller\FuncionRenalController;
use Illuminate\Support\Facades\Route;

Route::prefix('funcion-renal', 'throttle:60,1')->group(function () {
    Route::controller(FuncionRenalController::class)->group(function () {
        Route::post('listarFuncionRenal', 'listarFuncionRenal');
        Route::post('guardarResultados', 'guardarResultadosFr');

    });
});
