<?php

use App\Http\Modules\Afiliados\Controllers\AfiliadoController;
use Illuminate\Support\Facades\Route;

Route::prefix('actualizacion', 'throttle:60,1')->group(function () {

    Route::post('actualizacion-pacientes', [AfiliadoController::class, 'actualizacionPacientes']);

});
