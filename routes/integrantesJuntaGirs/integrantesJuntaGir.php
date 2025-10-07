<?php

use App\Http\Modules\IntegrantesJuntaGirs\Controllers\IntegrantesJuntaGirsController;
use Illuminate\Support\Facades\Route;

Route::prefix('integrantes-junta-girs', 'throttle:60,1')->group(function () {
    Route::controller(IntegrantesJuntaGirsController::class)->group(function() {
        Route::post('crear/{teleapoyo}', 'crear');
    });
});
