<?php

use App\Http\Modules\Historia\AntecedentesFarmacologicos\Controllers\AntecedentesFarmacologicosController;
use Illuminate\Support\Facades\Route;

Route::prefix('antecedentes-alergicos', 'throttle:60,1')->group(function ()
{
    Route::controller(AntecedentesFarmacologicosController::class)->group(function()
    {
        Route::post('guardar', 'guardar');//->middleware('permission:tutela.gestion.buscar');
        Route::post('listarAlergiaMedicamentos', 'listarAlergiaMedicamentos');//->middleware('permission:tutela.gestion.buscar');
        Route::post('listarAlergiaAmbiental', 'listarAlergiaAmbiental');
        Route::post('listarAlergiaAlimentos', 'listarAlergiaAlimentos');
        Route::post('listarOtras', 'listarOtras');
        Route::delete('eliminarAlergia/{id}', 'eliminarAlergia');        
    });
});
