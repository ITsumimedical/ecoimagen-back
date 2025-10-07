<?php

use App\Http\Modules\PracticaIntervieneSalud\Controllers\PracticaIntervieneSaludController;
use Illuminate\Support\Facades\Route;

Route::prefix('practica-interviene-salud', 'throttle:60,1')->group(function () {
    Route::controller(PracticaIntervieneSaludController::class)->group(function () {
       Route::get('listarTodas', 'listarTodas'); 
    });
});