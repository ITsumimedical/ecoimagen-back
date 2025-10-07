<?php

use App\Http\Modules\MedicoSedes\Controllers\MedicoSedeController;
use Illuminate\Support\Facades\Route;

Route::prefix('medico-sede', 'throttle:60,1')->group(function () {
    Route::controller(MedicoSedeController::class)->group(function() {
        Route::get('', 'listar');
        Route::get('{id}', 'listar');

    });
});
