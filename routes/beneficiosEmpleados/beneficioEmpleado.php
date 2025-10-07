<?php

use App\Http\Modules\BeneficiosEmpleados\Controllers\BeneficioEmpleadoController;
use Illuminate\Support\Facades\Route;

Route::prefix('beneficios-empleados')->group( function () {
    Route::controller(BeneficioEmpleadoController::class)->group(function (){
        Route::get('contadores-beneficios', 'contadoresBeneficios');//->middleware('permission:beneficioEmpleado.listar');
        Route::get('listar','listar');//->middleware('permission:beneficioEmpleado.listar');
        Route::post('crear','crear');//->middleware('permission:beneficioEmpleado.crear');
        Route::put('/{id}','actualizar');//->middleware('permission:beneficioEmpleado.actualizar');
        Route::get('exportar', 'exportar');//->middleware('permission:beneficioEmpleado.listar');
        Route::put('/autorizar/{beneficio}', 'autorizar');//->middleware('permission:beneficioEmpleado.autorizar');
        Route::put('/anular/{beneficioEmpleado}', 'anular');//->middleware('permission:beneficioEmpleado.anular');
    });
});
