<?php

use App\Http\Modules\Historia\ResultadoLaboratorio\Controllers\ResultadoLaboratorioController;
use Illuminate\Support\Facades\Route;

Route::prefix('resultado-laboratorio', 'throttle:60,1')->group(function ()
{
    Route::controller(ResultadoLaboratorioController::class)->group(function()
    {
        Route::post('guardar', 'guardar');//->middleware('permission:tutela.gestion.buscar');
        Route::post('listarResultado', 'listarResultado');//->middleware('permission:tutela.gestion.buscar');
        Route::delete('eliminarResultado/{id}', 'eliminarResultado');
        Route::post('listarResultadoRc', 'listarResultadoRiesgoCardiosvacular');
        Route::post('guardarMejora', 'guardarMejora');

    });
});
