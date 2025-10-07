<?php

use App\Http\Modules\Usuarios\Controllers\UsuarioController;
use Illuminate\Support\Facades\Route;

Route::prefix('usuarios', 'throttle:60,1')->group(function () {
    Route::controller(UsuarioController::class)->group(function () {
        Route::get('listar', 'listar')->middleware('permission:usuarios.vista');
        Route::get('buscarRoles/{user_id}', 'buscarRolesUsuario')->middleware('permission:usuarios.vista');
        Route::post('crear', 'crear')->middleware('permission:usuarios.vista');
        Route::post('actualizar/{id}', 'actualizar')->middleware('permission:usuarios.vista');
        Route::get('usuarioLogeado', 'usuarioLogeado');
        Route::post('agregarPermiso/{id}', 'agregarPermiso');
        Route::post('removerPermiso/{id}', 'removerPermiso');
        Route::post('agregarRol/{id}', 'agregarRol');
        Route::post('removerRol/{id}', 'removerRol');
        Route::get('agendaMedico/{user}', 'agendaMedico');
        Route::get('agendaMedicoCompleta/{user}', 'agendaMedicoCompleta');
        Route::get('medicosActivos', 'medicosActivos');
        Route::post('busqueda-usuario', 'buscarUsuario');
        Route::post('cambioContrasena', 'cambioContrasena');
        Route::post('agregarEntidad/{id}', 'agregarEntidad');
        Route::post('removerEntidad/{id}', 'removerEntidad');
        Route::post('especialidad', 'especialidad');
        Route::post('listarConfiltro', 'listarConfiltro');
        Route::post('asignarEspecialidad/{id}', 'agregarEspecialidad');
        Route::post('removerEspecialidad/{id}', 'removerEspecialidad');
        Route::post('cambiarEstado/{id}', 'cambiarEstado');
        Route::get('operadores-activos', 'listarOperadoresActivos');
        Route::post('editarInfoPerfil','editarInfoPerfil');
        Route::post('consultarImagen/{id}', 'consultarFirmaUsuario');
        Route::get('medicos-cirujanos','medicosCirujanos');
        Route::post('actualizar-contrasena-usuario/{id}','actualizarContrasenaUsuario');
    });
});
