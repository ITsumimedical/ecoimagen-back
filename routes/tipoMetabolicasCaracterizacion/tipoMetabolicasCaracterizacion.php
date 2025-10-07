<?php

use App\Http\Modules\TipoMetabolicasCaracterizacion\Controllers\TipoMetabolicasCaracterizacionController;
use Illuminate\Support\Facades\Route;

Route::prefix('tipo-metabolicas-caracterizacion', 'throttle:60,1')->group(function () {
    Route::controller(TipoMetabolicasCaracterizacionController::class)->group(function () {
        Route::get('listarTodas', 'listarTodas');
    });
});
