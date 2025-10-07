<?php

use App\Http\Modules\PerfilSociodemograficos\Controllers\PerfilSociodemograficoController;
use Illuminate\Support\Facades\Route;

Route::prefix('perfil-sociodemografico', 'throttle:60,1')->group(function () {
    Route::controller(PerfilSociodemograficoController::class)->group(function () {
        Route::get('{id}', 'listar');
        Route::post('crear', 'crear');
        Route::put('/{id}', 'actualizar');
    });
});
