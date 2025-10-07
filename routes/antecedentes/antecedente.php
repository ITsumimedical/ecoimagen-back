<?php

use App\Http\Modules\Historia\Antecedentes\Controllers\AntecedenteController;
use Illuminate\Support\Facades\Route;

Route::prefix('antecedentes', 'throttle:60,1')->group(function ()
{
    Route::controller(AntecedenteController::class)->group(function()
    {
        Route::post('guardar', 'guardar');//->middleware('permission:tutela.gestion.buscar');
        Route::get('listar', 'listar');//->middleware('permission:tutela.gestion.buscar');
    });
});
