<?php

use App\Http\Modules\Especialidades\Controllers\EspecialidadController;
use Illuminate\Support\Facades\Route;


Route::prefix('especialidades')->group(function () {
    Route::controller(EspecialidadController::class)->group(function () {
        Route::get('', 'listar');//->middleware('permission:especialidades.listar');
        Route::post('listarTodas', 'listarTodas');//->middleware('permission:especialidades.listar');
        Route::post('eliminarEspecialidad', 'eliminarEspecialidad');//->middleware('permission:especialidades.listar');
        Route::get('especialidadesEmpleados', 'especialidadesEmpleados');//->middleware('permission:especialidades.listar');
        Route::get('listarEspecialidadesConMedicos', 'listarEspecialidadesConMedicos');
        Route::post('listar', 'listar');//->middleware('permission:especialidades.listar.parametros');
        Route::post('crear', 'crear');//->middleware('permission:especialidades.crear');
        Route::put('/{id}', 'actualizar');//->middleware('permission:especialidades.actualizar');
        Route::post('especialidadMedico', 'especialidadMedico');
        Route::post('/especialidad-medico-adicional', 'especialidadMedicoAdicional');
        Route::post('especialidadCita', 'especialidadCita');
        Route::get('listar-medicos-y-auxiliares/{especialidad_id}', 'listarMedicosYauxiliares');
        Route::get('listarEspecialidadesMedicos/{user_id}', 'listarEspecialidadesPorMedico');
        Route::put('cambiarMarca/{id}', 'cambiarMarca');
        Route::post('listarEspecialidadesTelesalud', 'listarEspecialidadesTelesalud');
        Route::post('guardarCup', 'guardarCup');
        Route::post('agregar-grupos', 'agregarGrupos');
        Route::get('listar-grupos-especialidad/{especialidad_id}', 'listarGruposEspecialidad');
        Route::post('eliminar-grupos', 'eliminarGrupos');
    });
});
