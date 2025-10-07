<?php

use App\Http\Modules\Audit\Controller\auditController;
use Illuminate\Support\Facades\Route;

Route::prefix('audit')->group( function () {
    Route::controller(auditController::class)->group(function (){
        Route::post('crear','crear');
        Route::get('obtenerDatos/{afiliadoId}', 'obtenerDatos');
    });
});
