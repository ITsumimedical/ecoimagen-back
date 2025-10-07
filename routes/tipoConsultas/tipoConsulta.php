<?php

use App\Http\Modules\TipoConsultas\Controllers\TipoConsultaController;
use Illuminate\Support\Facades\Route;

Route::prefix('tipo-consultas')->group(function () {
    Route::controller(TipoConsultaController::class)->group(function () {
        Route::get('','listar');
    });
});