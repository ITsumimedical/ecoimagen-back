<?php

use App\Http\Modules\Empleados\Controllers\EmpleadoController;
use Illuminate\Support\Facades\Route;

Route::prefix('empleados', 'throttle:60,1')->group(function () {
    Route::controller(EmpleadoController::class)->group(function () {
        Route::get('contadoresEmpleados', 'contadoresEmpleados');
        Route::get('contadoresEmpleadosPorJefeInmediato', 'contadoresEmpleadosPorJefeInmediato');
        Route::get('compromisos-laborales', 'compromisosLaborales');
        Route::get('listar', 'listar');//->middleware('permission:empleado.listar');
        Route::get('jefe-empleados', 'jefe_empleados');
        Route::post('datos-medico-documento', 'listarEmpleadoPorDocumento');//->middleware('permission:empleado.listar');
        Route::post('datos-empleado-cedula', 'listarEmpleadoPorCedula');//->middleware('permission:empleado.listar');
        Route::post('crear', 'crear');//->middleware('permission:empleado.crear');
        Route::put('/{id}', 'actualizar');//->middleware('permission:empleado.actualizar');
        Route::get('exportar', 'exportEmpleadosProcedimiento');//->middleware('permission:empleado.listar');
        Route::get('compromisos/{documento}', 'compromisosEvaluacion');
        Route::get('exportEmpleadosProcedimiento', 'exportEmpleadosProcedimiento');
        Route::post('consultar-empleado-con-filtro', 'consultarEmpleadoConFiltro');//->middleware('permission:empleado.listar');
        Route::get('listarEmpleadosActivos','listarEmpleadosActivos');//->middleware('permission:empleado.listar');
        Route::get('listarEmpleadosContratados','listarEmpleadosContratados');//->middleware('permission:empleado.listar');
        Route::get('listarMedicoPorSede/{id}','listarMedicoPorSede');//->middleware('permission:empleado.listar');
        Route::post('firma', 'firma');
    });
});
