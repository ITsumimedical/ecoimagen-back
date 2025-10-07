<?php

use App\Http\Modules\Colegios\Controllers\ColegioController;
use Illuminate\Support\Facades\Route;


Route::prefix('colegios')->group(function (){
    Route::controller(ColegioController::class)->group(function (){
        Route::post('crear', 'registrarColegio');//->middleware('permission:consulta.crear');
        Route::get('listar', 'listarColegios');//->middleware('permission:consulta.citasindividuales');
        Route::get('listarTodos', 'listarTodos');
        Route::post('inactivarColegio', 'inactivarColegio');//->middleware('permission:consulta.citasindividuales');
        Route::post('activarColegio', 'activarColegio');
        Route::get('buscarColegio/{nombre}', 'buscarColegio');
        Route::get('colegioDepartamento/{departamento_id}','listarColegioDepartamento');
    });
});
