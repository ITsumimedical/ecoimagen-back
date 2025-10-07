<?php

use App\Http\Modules\PortabilidadHistorico\Controllers\PortabilidadHistoricoController;
use Illuminate\Support\Facades\Route;

Route::prefix('portabilidad-historico', 'throttle:60,1')->group(function () {
    Route::controller(PortabilidadHistoricoController::class)->group(function () {
        Route::get('portabilidadHistorico', 'portabilidadHistorico');
    });
});
