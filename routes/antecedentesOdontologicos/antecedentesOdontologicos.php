<?php

use App\Http\Modules\AntecedentesOdontologicos\Controllers\antecedentesOdontologicosController;
use Illuminate\Support\Facades\Route;

Route::prefix('antecedente-odontologico', 'throttle:60,1')->group(function () {
    Route::controller(antecedentesOdontologicosController::class)->group(function() {
        Route::post('crear','crear');
    });
});
