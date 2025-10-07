<?php

use App\Http\Modules\Citas\Controllers\CitaController;
use Illuminate\Support\Facades\Route;


Route::prefix('citas')->group(function () {
    Route::controller(CitaController::class)->group(function () {
        Route::get('', 'listar'); //->middleware(['permission:listar.cita']);
        Route::post('listar', 'listar'); //->middleware(['permission:listarFiltro.cita']);
        Route::post('crear', 'crear'); //->middleware(['permission:crear.cita']);
        Route::put('/{id}', 'actualizar'); //->middleware(['permission:actualizar.cita']);
        Route::get('historiaClinicaCita', 'historiaClinicaCita'); //->middleware(['permission:historiaClinicaCita.cita']);
        Route::get('plantilla-historia', 'plantillaHistoriaCita'); //->middleware(['permission:plantillaCita.cita']);
        Route::post('aplicar-plantilla', 'aplicarPlantilla'); //->middleware(['permission:aplicarPlantilla.cita']);
        Route::post('cups-disponibles', 'cupsDisponibles');
        Route::get('historia-disponibles/{especialidad}', 'historiaDisponibles');
        Route::post('consultarPorEspecialidad', 'consultarPorEspecialidad');
        Route::post('consultarPorEspecialidadTodas', 'consultarPorEspecialidadTodas');
        Route::post('citaOrdenPaciente', 'citaOrdenPaciente');
        Route::get('listarCitasAutogestion', 'listarCitasAutogestion');
        Route::put('cambiarEstado/{id}', 'cambiarEstadoCita');
        Route::get('filtrarCitas', 'filtrarCitas');
        Route::put('cambiarFirma/{id}', 'cambiarFirma');
        Route::post('asignar-reps-cita', 'asignarCitaReps');
        Route::get('listar-reps-cita/{id}', 'listarRepsPorCita');
        Route::get('listar-log-keiron', 'listarLogKeiron');
        Route::post('listar-faltantes-keiron', 'listarFaltantesKeiron');
        Route::get('contador-faltantes-keiron', 'contadorFaltantesKeiron');
        Route::post('listar-canceladas-faltantes-keiron', 'listarCanceladasFaltantes');
        Route::post('activar-autogestion/{id}','activarAutogestion');
    });
});
