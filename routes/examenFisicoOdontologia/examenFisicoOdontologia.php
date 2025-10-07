<?php


use App\Http\Modules\ExamenFisicoOdontologia\Controller\examenFisicoOdontologiaController;
use Illuminate\Support\Facades\Route;

Route::prefix('examen-odontologia','throttle:60,1v')->group(function(){
    Route::controller(examenFisicoOdontologiaController::class)->group(function(){
        Route::post('crear','crear');
    });
});
