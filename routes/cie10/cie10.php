<?php

use App\Http\Modules\Cie10\Controllers\Cie10Controller;
use Illuminate\Support\Facades\Route;

Route::prefix('cie10', 'throttle:60,1')->group(function () {
    Route::controller(Cie10Controller::class)->group(function () {
        Route::get('listar', 'listar');
        Route::post('listarFiltro', 'listarFiltro');
        Route::get('listarAntecedentesPersonales', 'listarAntecedentesPersonales');
        Route::get('listarc10','listarc10');
        Route::post('consultarCie10Consulta','consultarCie10Consulta');
        Route::get('cie10Primario/{consulta}','cie10Primario');
    });
});
