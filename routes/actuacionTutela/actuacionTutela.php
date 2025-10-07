<?php

use App\Http\Modules\ActuacionTutelas\Controllers\ActuacionTutelaControllers;
use Illuminate\Support\Facades\Route;

Route::prefix('actuacion-tutela', 'throttle:60,1')->group(function ()
{
    Route::controller(ActuacionTutelaControllers::class)->group(function()
    {
        Route::get('{id}', 'listar');
        Route::post('asignar', 'asignar');
        Route::post('crear', 'crear');
        Route::post('listarAsignada', 'listarAsignada');
        Route::post('listarAsignadaCerrada', 'listarAsignadaCerrada');
        Route::post('listarAsignadaCerradaTemporal','listarAsignadaCerradaTemporal');
    });
});
