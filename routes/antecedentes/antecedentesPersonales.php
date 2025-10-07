<?php

use App\Http\Modules\Historia\AntecedentesPersonales\Controllers\AntecedentePersonaleController;
use Illuminate\Support\Facades\Route;

Route::prefix('antecedentes-personales', 'throttle:60,1')->group(function () {
    Route::controller(AntecedentePersonaleController::class)->group(function () {
        Route::post('guardar', 'guardar'); //->middleware('permission:tutela.gestion.buscar');
        Route::post('listar', 'listar'); //->middleware('permission:tutela.gestion.buscar');
        Route::get('listarAntecedente/{numero_documento}', 'listarAntecedenteAfiliado');
        Route::delete('eliminar/{id}', 'eliminar'); //->middleware('permission:tutela.gestion.buscar');
        Route::get('obtenerDiabetes/{afiliado_id}', 'obtenerDiabetes'); 
    });
});
