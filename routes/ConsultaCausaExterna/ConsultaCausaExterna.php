<?php

use App\Http\Modules\ConsultaCausaExterna\Controllers\ConsultaCausaExternaController;
use Illuminate\Support\Facades\Route;

Route::prefix('consultaCausaExterna', 'throttle:60,1')->group(function () {
    Route::controller(ConsultaCausaExternaController::class)->group(function () {
        Route::post('crear', 'crear');
        Route::get('listarConsulta', 'listarConsulta');
        Route::get('listarActivas', 'listarActivas');
        Route::put('cambiarEstado/{id}', 'cambiarEstado');
    });
});
