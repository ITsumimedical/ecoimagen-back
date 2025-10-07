<?php

use App\Http\Modules\Departamentos\Controllers\DepartamentoController;
use Illuminate\Support\Facades\Route;

Route::prefix('departamento', 'throttle:60,1')->group(function () {

    Route::controller(DepartamentoController::class)->group(function () {
        Route::get('/', 'listar');
        //Ruta de departamentos cachados con REDIS
        Route::get('/listar-departamentos', 'listarDepartamentos');
    });
});
