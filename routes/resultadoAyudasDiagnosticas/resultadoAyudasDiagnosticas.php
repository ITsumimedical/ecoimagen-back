<?php

use App\Http\Modules\ResultadoAyudasDiagnosticos\Controller\ResultadoAyudasDiagnosticasController;
use Illuminate\Support\Facades\Route;

Route::prefix('resultadoAyudas', 'throttle:60,1')->group(function () {
    Route::controller(ResultadoAyudasDiagnosticasController::class)->group(function (){
        Route::post('crear', 'crear');
        Route::get('listarAyudas/{id}', 'listarAyudasDiagnosticas');
        Route::delete('eliminar/{id}', 'eliminar');
    });
});
