<?php

use App\Http\Modules\Codesumis\viasAdministracion\Controllers\viasAdministracionController;
use Illuminate\Support\Facades\Route;

Route::prefix('vias-administracion','throttle:60,1')->group(function () {
    Route::controller(viasAdministracionController::class)->group(function () {
        Route::get('listar', 'listar');
        Route::post('crear', 'crear');
        Route::put('actualizar/{id}', 'actualizar');
        Route::delete('eliminar/{id}', 'eliminar');
    });
});

