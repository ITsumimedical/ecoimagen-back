<?php

use App\Http\Modules\Historia\Vacunacion\Controllers\VacunacionController;
use Illuminate\Support\Facades\Route;

Route::prefix('antecedentes-vacunales', 'throttle:60,1')->group(function ()
{
    Route::controller(VacunacionController::class)->group(function()
    {
        Route::post('guardar', 'guardar');//->middleware('permission:tutela.gestion.buscar');
        Route::post('listar', 'listar');//->middleware('permission:tutela.gestion.buscar');
        Route::delete('eliminar/{id}', 'eliminar');//->middleware('permission:tutela.gestion.buscar');
        Route::post('guardarNotieneAntecedente', 'guardarNotieneAntecedente');
    });
});
