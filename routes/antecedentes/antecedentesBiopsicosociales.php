<?php

use App\Http\Modules\Historia\AntecedentesEcomapas\Controllers\AntecedenteEcomapaController;
use Illuminate\Support\Facades\Route;

Route::prefix('antecedentes-biopsicosociales', 'throttle:60,1')->group(function ()
{
    Route::controller(AntecedenteEcomapaController::class)->group(function()
    {
        Route::post('guardarEcomapa', 'guardarEcomapa');//->middleware('permission:tutela.gestion.buscar');
        Route::post('listarEcomapa', 'listarEcomapa');//->middleware('permission:tutela.gestion.buscar');
        Route::get('obtenerDatos/{afiliadoId}', 'obtenerDatos');
    });
});
