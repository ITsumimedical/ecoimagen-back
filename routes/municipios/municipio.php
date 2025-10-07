<?php

use App\Http\Modules\Municipios\Controllers\MunicipioController;
use Illuminate\Support\Facades\Route;

Route::prefix('municipios', 'throttle:60,1')->group(function () {
    Route::controller(MunicipioController::class)->group(function () {
        Route::get('listar', 'listar');
        Route::get('reps/{municipio}','listarReps');
        //Ruta de municipios cachados con REDIS
        Route::get('/listar-municipios', 'listarMunicipios');
        // Consulta de municipios por departamento
        Route::get('/listar-municipios-por-departamentos', 'listarMunicipiosPorDepartamento');
        Route::get('listar-por-departamento/{departamentoId}', 'listarPorDepartamento');

    });
});
