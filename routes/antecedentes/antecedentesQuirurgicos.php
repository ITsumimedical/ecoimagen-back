<?php

use App\Http\Modules\Historia\AntecedentesQuirurgicos\Controllers\AntecedenteQuirurgicoController;
use Illuminate\Support\Facades\Route;

Route::prefix('antecedentes-quirurgicos', 'throttle:60,1')->group(function ()
{
    Route::controller(AntecedenteQuirurgicoController::class)->group(function()
    {
        Route::post('guardar', 'guardar');//->middleware('permission:tutela.gestion.buscar');
        Route::post('listar', 'listar');//->middleware('permission:tutela.gestion.buscar');
        Route::delete('eliminar/{id}', 'eliminar');//->middleware('permission:tutela.gestion.buscar');
        Route::post('guardarNotieneAntecedente', 'guardarNotieneAntecedente');
    });
});
