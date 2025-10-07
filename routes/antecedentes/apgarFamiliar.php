<?php

use App\Http\Modules\Historia\ApgarFamiliar\Controllers\ApgarFamiliarController;
use Illuminate\Support\Facades\Route;

Route::prefix('apgar-familiar', 'throttle:60,1')->group(function ()
{
    Route::controller(ApgarFamiliarController::class)->group(function()
    {
        Route::post('guardarApgar', 'guardarApgar');//->middleware('permission:tutela.gestion.buscar');
        Route::post('listarApgar', 'listarApgar');//->middleware('permission:tutela.gestion.buscar');
        Route::get('obtenerDatosApgar/{afiliadoId}', 'obtenerDatosApgar');
    });
});
