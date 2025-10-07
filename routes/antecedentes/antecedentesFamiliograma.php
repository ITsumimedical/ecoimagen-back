<?php

use App\Http\Modules\Historia\AntecedentesFamiliograma\Controllers\AntecedenteFamiliogramaController;
use Illuminate\Support\Facades\Route;

Route::prefix('antecedentes-familiograma', 'throttle:60,1')->group(function ()
{
    Route::controller(AntecedenteFamiliogramaController::class)->group(function()
    {
        Route::post('guardarFamiliograma', 'guardarFamiliograma');//->middleware('permission:tutela.gestion.buscar');
        Route::post('listarFamiliograma', 'listarFamiliograma');//->middleware('permission:tutela.gestion.buscar');
        Route::get('obtenerDatosFamiliograma/{afiliadoId}', 'obtenerDatosFamiliograma');
    });
});
