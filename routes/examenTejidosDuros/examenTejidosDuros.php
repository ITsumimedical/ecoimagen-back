<?php

use App\Http\Modules\ExamenTejidosDuros\Controller\examenTejidosDurosController;
use Illuminate\Support\Facades\Route;

Route::prefix('examen-tejidos','throttle:60,1v')->group(function(){
    Route::controller(examenTejidosDurosController::class)->group(function(){
        Route::post('crear','crear');
    });
});
