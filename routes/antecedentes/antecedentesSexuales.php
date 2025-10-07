<?php

use App\Http\Modules\Historia\AntecedentesSexuales\Controllers\AntecedenteSexualesController;
use Illuminate\Support\Facades\Route;

Route::prefix('antecedentes-sexuales', 'throttle:60,1')->group(function ()
{
    Route::controller(AntecedenteSexualesController::class)->group(function()
    {
        Route::post('guardar', 'guardar');//->middleware('permission:tutela.gestion.buscar');
        Route::get('listar', 'listar');//->middleware('permission:tutela.gestion.buscar');
    });
});
