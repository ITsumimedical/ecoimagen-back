<?php

use App\Http\Modules\Historia\AntecedentesPersonales\Controllers\AntecedentePersonaleController;
use Illuminate\Support\Facades\Route;

Route::prefix('antecedentes-personales', 'throttle:60,1')->group(function ()
{
    Route::controller(AntecedentePersonaleController::class)->group(function()
    {
        Route::post('guardar-antecedentes-personales', 'guardar');//->middleware('permission:tutela.gestion.buscar');
        Route::get('listar-antecedentes-personales', 'listar');//->middleware('permission:tutela.gestion.buscar');
    });
});
