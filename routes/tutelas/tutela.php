<?php

use App\Http\Modules\Tutelas\Controllers\TutelaController;
use Illuminate\Support\Facades\Route;

Route::prefix('tutela', 'throttle:60,1')->group(function ()
{
    Route::controller(TutelaController::class)->group(function()
    {
        //Route::post('buscar', 'buscarTutela');//->middleware('permission:tutela.gestion.buscar');
        Route::get('listar/{afiliado}', 'listar');//->middleware('permission:tutela.gestion.listar');
        Route::post('/listarAccion','listarAccion');
        Route::post('crear','crear');//->middleware('permission:tutela.gestion.guardar');
        Route::post('cerrarTutela','cerrarTutela');//->middleware('permission:tutela.gestion.guardar');
        Route::post('/cerrarTutelaTemporal', 'cerrarTutelaTemporal');//->middleware('permission:tutela.gestion.actualizar');
        Route::post('abrirTutela','abrirTutela');//->middleware('permission:tutela.gestion.guardar');
        Route::put('/{id}','actualizar');//->middleware('permission:tutela.gestion.actualizar');
    });
});
